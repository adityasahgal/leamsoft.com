<?php

namespace App\Support\Chatbot;

use Anthropic\Client;
use Anthropic\RequestOptions;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Website chatbot answers written by Claude, grounded in the same site
 * content as /llms.txt and the FAQ. Returns null on any failure or refusal
 * so the caller can fall back to KeywordAssistant.
 */
class ClaudeAssistant
{
    public const SYSTEM_CACHE_KEY = 'chatbot.system';

    public static function available(): bool
    {
        return (bool) config('chatbot.api_key');
    }

    /**
     * @param  array<int, array{role: string, content: string}>  $history  oldest first, ends with the user's turn
     */
    public function reply(array $history): ?string
    {
        try {
            $client = new Client(
                apiKey: config('chatbot.api_key'),
                requestOptions: RequestOptions::with(
                    timeout: 25,
                    maxRetries: 1,
                    transporter: new \GuzzleHttp\Client(['timeout' => 25, 'connect_timeout' => 5]),
                ),
            );

            $message = $client->beta->messages->create(
                model: config('chatbot.model'),
                maxTokens: (int) config('chatbot.max_tokens', 4000),
                system: [
                    // Frozen per content version, so it caches across visitors
                    ['type' => 'text', 'text' => self::systemPrompt(), 'cacheControl' => ['type' => 'ephemeral']],
                ],
                messages: $history,
                outputConfig: ['effort' => config('chatbot.effort', 'low')],
                // If the model declines on policy grounds, let the API retry
                // on its default fallback model inside the same call
                fallbacks: 'default',
                betas: ['server-side-fallback-2026-07-01'],
            );

            if ($message->stopReason === 'refusal') {
                return null;
            }

            $text = '';
            foreach ($message->content as $block) {
                if ($block->type === 'text') {
                    $text .= $block->text;
                }
            }

            $text = trim($text);

            return $text !== '' ? $text : null;
        } catch (\Throwable $e) {
            Log::warning('Chatbot AI reply failed: ' . $e->getMessage());

            return null;
        }
    }

    /**
     * Instructions + site knowledge. Built once and cached; flushed with the
     * other site caches whenever content changes in admin.
     */
    public static function systemPrompt(): string
    {
        return Cache::remember(self::SYSTEM_CACHE_KEY, 3600, function () {
            $meeting = route('meeting.create');
            $contact = url('contact-us');

            $faq = [];
            foreach (config('site.faqs', []) as $group => $items) {
                $faq[] = '### ' . $group;
                foreach ($items as [$q, $a]) {
                    $faq[] = "Q: {$q}\nA: {$a}";
                }
            }
            $knowledge = trim(SeoController::buildLlms());
            $faqText = implode("\n\n", $faq);

            return <<<PROMPT
You are the Leamsoft Assistant, the chat assistant on the website of Leamsoft Pvt Ltd., a software, AI and cloud engineering company in Delhi NCR, India. The people writing to you are mostly potential clients exploring whether Leamsoft can help them.

How to answer:
- Base your answers on the site knowledge and FAQ below. When something isn't covered there (exact prices, named clients, delivery guarantees, availability of specific people), say you're not certain and offer a call with the team instead of guessing.
- Keep replies short and conversational: two to four sentences, roughly under 80 words. Plain text only, no headings, tables or bullet lists. When pointing to a page, write its full URL from the knowledge below.
- Reply in the visitor's language: English, Hindi or Hinglish, matching how they write.
- When someone wants to start a project, get a quote, or speak to a person, suggest booking a free 30-minute call at {$meeting} or sending details through {$contact}.
- Stay on Leamsoft, its services and closely related technology questions. Politely decline unrelated requests and steer back to how Leamsoft can help.
- Never ask for passwords, payment card details or other sensitive personal data. A name, phone number or email for a callback is fine if the visitor offers it.

# Site knowledge

{$knowledge}

# FAQ

{$faqText}
PROMPT;
        });
    }
}
