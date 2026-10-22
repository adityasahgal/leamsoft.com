<?php

/*
|--------------------------------------------------------------------------
| Frequently asked questions
|--------------------------------------------------------------------------
| Shown on /faq (with FAQPage schema) and used as knowledge by the website
| chatbot. Group => [[question, answer], ...]
*/

return [

    'faqs' => [
        'Working with Leamsoft' => [
            ['What types of projects do you take on?', 'We work across web development, mobile apps, AI/ML, cloud infrastructure, cyber security and digital marketing. Whether you have a fully scoped brief or a rough idea, we can shape it into a delivery plan together.'],
            ['What does the engagement process look like?', 'A typical engagement starts with a 30-minute discovery call, followed by a written scope and a fixed-price or T&M proposal. Once you sign, we run agile two-week sprints with weekly demos and full transparency in the project management tool of your choice.'],
            ['Do you work with startups or only enterprise?', 'Both. About 40% of our clients are early-stage startups; the rest range from mid-market to large enterprises. Our delivery model adapts — lightweight processes for startup speed and heavier governance for enterprise.'],
        ],
        'Pricing & timeline' => [
            ['How do you price projects?', 'Two models: fixed-price for well-scoped projects, and time & materials for ongoing or exploratory work. We share rate cards upfront and never have hidden fees.'],
            ['How fast can you start?', 'For small projects, often within a week. For larger engagements requiring a dedicated team, allow 2–4 weeks for resourcing. Urgent work? Tell us — we can usually accommodate.'],
            ['Do you sign NDAs?', 'Yes, mutual NDAs are standard before any detailed scoping discussion. Send us yours or use ours.'],
        ],
        'Technology & team' => [
            ['What technologies do you specialise in?', 'Frontend: React, Vue, Next.js. Backend: Node.js, Python, Laravel, .NET. Mobile: React Native, Swift, Kotlin. AI: PyTorch, LLM integration. Cloud: AWS, Azure, GCP. We pick the right tool for the job, not the trendiest one.'],
            ['Who actually does the work?', 'Senior engineers with years of shipped work. No bait-and-switch — the team you meet during scoping is the team you get.'],
            ['Do you offer ongoing maintenance after launch?', 'Yes. Most clients move into a managed support contract after launch covering monitoring, bug fixes, security patches and minor enhancements.'],
        ],
        'IP, security & legal' => [
            ['Who owns the code?', 'You do. All work product is assigned to you on payment, including source code, designs and documentation. No vendor lock-in.'],
            ['How do you handle data security?', 'Production access is least-privilege and audited. We follow the OWASP Top 10 in code, SOC2-aligned operational practices, and offer ISO 27001 compliance assistance.'],
            ['Can we run our own security review?', 'Absolutely encouraged. We provide architecture docs, threat models and access for your pen-test or code-review partners.'],
        ],
    ],

];
