<?php

namespace App\Support\Chatbot;

use App\Models\Category;
use App\Models\Setting;
use App\Models\Subcategory;
use App\Support\Ui;
use Illuminate\Support\Str;

/**
 * Answers common visitor questions from the site's own data -- no external
 * calls. Used on its own when no API key is configured, and as the safety
 * net whenever the AI assistant can't answer.
 */
class KeywordAssistant
{
    private const STOP = [
        'and', 'the', 'for', 'with', 'you', 'your', 'are', 'can', 'what', 'how', 'does', 'do', 'have',
        'services', 'service', 'solutions', 'solution', 'development', 'company', 'about', 'me', 'need',
        'want', 'kya', 'hai', 'ka', 'ki', 'ke', 'mujhe', 'chahiye', 'aap', 'please', 'tell',
    ];

    /** @return array{reply: string, actions: array<int, array{label: string, url: string}>} */
    public function reply(string $text): array
    {
        $t = ' ' . Str::lower(preg_replace('/[^\pL\pN\s&\/-]+/u', ' ', $text)) . ' ';
        $setting = Setting::first();
        $meet = ['label' => 'Schedule a meeting', 'url' => route('meeting.create')];
        $contact = ['label' => 'Contact us', 'url' => url('contact-us')];
        $services = ['label' => 'Our services', 'url' => url('services')];

        if ($this->has($t, ['meeting', 'meet', 'call', 'schedule', 'book', 'demo', 'consultation', 'appointment', 'baat', 'milna', 'discuss'])) {
            return $this->out(
                'Happy to set that up! You can book a free 30-minute call with a senior engineer — pick a day and time that suits you, by video, phone or in person in Delhi NCR.',
                [$meet, $contact]
            );
        }

        if ($this->has($t, ['price', 'pricing', 'cost', 'budget', 'charge', 'charges', 'rate', 'rates', 'quote', 'quotation', 'kitna', 'kitne paise', 'fees', 'estimate'])) {
            return $this->out(
                'Pricing depends on scope. We work either fixed-price for well-defined projects or time-and-materials for ongoing work, and we share a written estimate after a short discovery call — no hidden fees. Tell us a little about your project and we’ll come back with numbers.',
                [$meet, $contact]
            );
        }

        if ($this->has($t, ['timeline', 'how long', 'kitne din', 'kitna time', 'deadline', 'how fast', 'when can you start', 'how soon'])) {
            return $this->out(
                'Small projects can usually start within a week; larger engagements with a dedicated team take 2–4 weeks to set up. We work in two-week sprints with a demo every week, so you see progress early.',
                [$meet]
            );
        }

        if ($this->has($t, ['job', 'jobs', 'career', 'careers', 'hiring', 'internship', 'vacancy', 'resume', 'cv'])) {
            $email = $setting->email ?? null;
            return $this->out(
                'Thanks for your interest in joining Leamsoft! ' . ($email ? "Please email your CV to {$email} with the role you’re interested in." : 'Please send your CV through our contact page with the role you’re interested in.'),
                [$contact]
            );
        }

        if ($this->has($t, ['contact', 'phone', 'number', 'email', 'mail', 'whatsapp', 'address', 'office', 'location', 'where are you', 'kahan', 'reach'])) {
            $lines = array_filter([
                !empty($setting->phone) ? 'Phone / WhatsApp: ' . $setting->phone : null,
                !empty($setting->email) ? 'Email: ' . $setting->email : null,
                ($addr = \App\Models\Meeting::officeAddress()) ? 'Office: ' . $addr : null,
            ]);
            $actions = [$contact, $meet];
            if (!empty($setting->phone)) {
                $actions[] = ['label' => 'WhatsApp us', 'url' => 'https://wa.me/' . preg_replace('/[^0-9]/', '', $setting->phone)];
            }
            return $this->out("You can reach the team here:\n" . implode("\n", $lines) . "\nWe usually reply within one business day (Mon–Sat, 9am–7pm IST).", $actions);
        }

        if ($match = $this->matchService($t)) {
            return $this->out(
                $match['name'] . ': ' . rtrim(Ui::excerpt($match['desc'], 220), '.') . '. Want to talk it through with an engineer?',
                [['label' => 'View ' . $match['name'], 'url' => $match['url']], $meet]
            );
        }

        if ($this->has($t, ['service', 'services', 'what do you do', 'offer', 'kya karte', 'expertise', 'capabilities'])) {
            $names = Category::where('status', 1)->orderBy('sort_order')->pluck('name')->take(8)->all();
            return $this->out(
                'We design, build and run software for businesses: ' . ($names ? implode(', ', $names) : 'web and mobile apps, AI, cloud, security and digital marketing') . '. Which one are you interested in?',
                [$services, $meet]
            );
        }

        if ($faq = $this->matchFaq($t)) {
            return $this->out($faq, [$meet, ['label' => 'All FAQs', 'url' => url('faq')]]);
        }

        if ($this->has($t, ['blog', 'article', 'articles', 'read', 'insight'])) {
            return $this->out('Our blog covers AI, innovation and engineering — practical notes from the team.', [['label' => 'Read the blog', 'url' => url('blog')]]);
        }

        if ($this->has($t, ['about', 'who are you', 'team', 'experience', 'leamsoft', 'company'])) {
            return $this->out(
                'Leamsoft Pvt Ltd. is a software, AI and cloud engineering company based in Delhi NCR. A senior team designs, builds and supports web platforms, mobile apps, AI automation and cloud infrastructure for startups and enterprises — and you own all the code.',
                [['label' => 'About us', 'url' => url('about-us')], $meet]
            );
        }

        if ($this->has($t, ['thank', 'thanks', 'thx', 'shukriya', 'dhanyavad', 'bye', 'great', 'ok', 'okay'])) {
            return $this->out('You’re welcome! If anything else comes up, I’m right here.', [$meet]);
        }

        if ($this->has($t, ['hi', 'hello', 'hey', 'hii', 'namaste', 'good morning', 'good evening', 'hola'])) {
            return $this->out('Hi! I’m the Leamsoft assistant. Ask me about our services, pricing, timelines — or book a free call with the team.', [$services, $meet]);
        }

        return $this->out(
            'I’m not sure I have the answer to that. The quickest way is to talk to our team — book a free call, or leave your number and someone will get back to you.',
            [$meet, $contact]
        );
    }

    private function out(string $reply, array $actions): array
    {
        return ['reply' => $reply, 'actions' => array_values($actions)];
    }

    /** Whole-word / phrase match against any of the needles. */
    private function has(string $haystack, array $needles): bool
    {
        foreach ($needles as $n) {
            if (str_contains($haystack, ' ' . $n . ' ') || (strlen($n) > 4 && str_contains($haystack, $n))) {
                return true;
            }
        }

        return false;
    }

    /** Common variants mapped onto the words used in service names */
    private const SYNONYMS = [
        'website' => 'web', 'websites' => 'web', 'webapp' => 'web', 'site' => 'web',
        'apps' => 'app', 'application' => 'app', 'applications' => 'app', 'android' => 'mobile', 'ios' => 'mobile',
        'chatbot' => 'llm', 'chatbots' => 'llm', 'gpt' => 'llm', 'chatgpt' => 'llm',
        'shop' => 'ecommerce', 'store' => 'ecommerce', 'shopify' => 'ecommerce',
        'aws' => 'cloud', 'azure' => 'cloud', 'gcp' => 'cloud', 'server' => 'cloud', 'hosting' => 'cloud',
        'hacking' => 'security', 'pentest' => 'penetration', 'marketing' => 'marketing', 'ads' => 'marketing',
    ];

    private function tokens(string $text): array
    {
        // "E-Commerce" and "ecommerce" should be the same word
        $text = preg_replace('/(\pL)-(\pL)/u', '$1$2', Str::lower($text));
        $words = preg_split('/[^\pL\pN]+/u', $text, -1, PREG_SPLIT_NO_EMPTY);
        $words = array_map(fn ($w) => self::SYNONYMS[$w] ?? $w, $words);

        return array_values(array_diff(array_filter($words, fn ($w) => strlen($w) >= 2), self::STOP));
    }

    /** Best category / subcategory whose name words appear in the question. */
    private function matchService(string $t): ?array
    {
        $user = array_flip($this->tokens($t));
        $best = null;
        $bestScore = 0;

        $rows = Category::where('status', 1)->get()->concat(Subcategory::where('status', 1)->get());
        foreach ($rows as $row) {
            $score = 0;
            foreach ($this->tokens($row->name) as $w) {
                if (isset($user[$w])) {
                    $score += strlen($w) <= 3 ? 2 : 1; // "ai", "seo", "erp" are strong signals
                }
            }
            // Words in the short description count for less than the name,
            // e.g. "CRM" lives in Enterprise Software's description
            foreach (array_unique($this->tokens((string) $row->short_description)) as $w) {
                if (isset($user[$w])) {
                    $score += strlen($w) <= 3 ? 1 : 0.5;
                }
            }
            // Prefer the more specific subcategory on a tie
            if ($score > $bestScore || ($score === $bestScore && $score > 0 && $row instanceof Subcategory)) {
                $bestScore = $score;
                $best = $row;
            }
        }

        if (! $best || $bestScore < 1) {
            return null;
        }

        return ['name' => $best->name, 'desc' => (string) $best->short_description, 'url' => url($best->slug)];
    }

    /** FAQ answer whose question shares enough words with the visitor's. */
    private function matchFaq(string $t): ?string
    {
        $user = array_flip($this->tokens($t));
        if (count($user) < 2) {
            return null;
        }

        $bestAnswer = null;
        $bestScore = 0;
        foreach (config('site.faqs', []) as $items) {
            foreach ($items as [$q, $a]) {
                $qt = $this->tokens($q);
                $hits = count(array_filter($qt, fn ($w) => isset($user[$w])));
                $score = $qt ? $hits / count($qt) : 0;
                if ($hits >= 2 && $score > $bestScore) {
                    $bestScore = $score;
                    $bestAnswer = $a;
                }
            }
        }

        return $bestScore >= 0.4 ? $bestAnswer : null;
    }
}
