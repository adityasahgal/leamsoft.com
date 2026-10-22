<?php

namespace App\Http\Controllers;

use App\Mail\EnquiryReceived;
use App\Models\Enquiry;
use App\Support\Chatbot\ClaudeAssistant;
use App\Support\Chatbot\KeywordAssistant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Website chat widget. The conversation lives in the server-side session,
 * so the browser only ever sends the newest message -- it can't rewrite
 * earlier turns or inject fake assistant replies.
 */
class ChatController extends Controller
{
    private const SESSION_KEY = 'chat.history';

    public function message(Request $request)
    {
        abort_unless(config('chatbot.enabled'), 404);

        $data = $request->validate([
            'message' => 'required|string|max:' . (int) config('chatbot.max_message_chars', 1000),
        ]);
        $text = trim($data['message']);

        $history = session(self::SESSION_KEY, []);
        $history[] = ['role' => 'user', 'content' => $text];
        $history = $this->trim($history);

        $keyword = (new KeywordAssistant())->reply($text);
        $reply = null;
        $mode = 'keyword';

        if (ClaudeAssistant::available()) {
            $reply = (new ClaudeAssistant())->reply($history);
            $mode = $reply !== null ? 'ai' : 'keyword';
        }

        // Quick-action buttons come from the keyword engine either way
        $reply ??= $keyword['reply'];

        $history[] = ['role' => 'assistant', 'content' => $reply];
        session([self::SESSION_KEY => $this->trim($history)]);

        return response()->json([
            'reply'   => $reply,
            'actions' => $keyword['actions'],
            'mode'    => $mode,
        ]);
    }

    public function reset()
    {
        session()->forget(self::SESSION_KEY);

        return response()->json(['ok' => true]);
    }

    /**
     * "Leave your number" from the chat: saved as an enquiry (with the chat
     * transcript) so it shows up in admin > Enquiry and the admin inbox.
     */
    public function lead(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|numeric|digits_between:10,15',
            'email'   => 'nullable|email|max:255',
            'message' => 'nullable|string|max:1000',
            'website' => 'prohibited', // honeypot
        ], [
            'phone.numeric'        => 'Please enter a valid phone number.',
            'phone.digits_between' => 'The phone number must be between 10 and 15 digits.',
        ]);

        $transcript = collect(session(self::SESSION_KEY, []))
            ->take(-10)
            ->map(fn ($m) => ($m['role'] === 'user' ? 'Visitor: ' : 'Assistant: ') . $m['content'])
            ->implode("\n");

        $enquiry = new Enquiry();
        $enquiry->pname = 'Website chat';
        $enquiry->name = $data['name'];
        $enquiry->email = $data['email'] ?? '';
        $enquiry->phone = $data['phone'];
        $enquiry->message = trim(($data['message'] ?? '') . ($transcript ? "\n\n--- Chat transcript ---\n" . $transcript : ''))
            ?: 'Callback requested from the website chat.';
        $enquiry->save();

        try {
            Mail::to(config('mail.enquiry_to'))->send(new EnquiryReceived($enquiry));
        } catch (\Throwable $e) {
            Log::error('Chat lead mail failed: ' . $e->getMessage());
        }

        $first = strtok($data['name'], ' ');

        return response()->json([
            'ok'    => true,
            'reply' => "Thanks {$first}! Our team will call you on {$data['phone']} within one business day. Want to pick a time now instead?",
            'actions' => [['label' => 'Schedule a meeting', 'url' => route('meeting.create')]],
        ]);
    }

    /** Keep the last N turns, always starting on a user turn. */
    private function trim(array $history): array
    {
        $max = (int) config('chatbot.history_turns', 12);
        $history = array_slice($history, -$max);
        while ($history && $history[0]['role'] !== 'user') {
            array_shift($history);
        }

        return array_values($history);
    }
}
