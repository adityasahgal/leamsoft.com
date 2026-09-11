<?php

/*
|--------------------------------------------------------------------------
| SEO Configuration
|--------------------------------------------------------------------------
|
| Central source of truth for on-page SEO. Nothing is hardcoded into the
| Blade views -- App\Support\Seo reads this file and builds titles,
| descriptions and keyword sets at render time.
|
| Tune the market targeting below and every page updates at once.
|
*/

return [

    // Brand ------------------------------------------------------------
    'brand'       => env('SEO_BRAND', 'Leamsoft Pvt Ltd.'),
    'short_brand' => env('SEO_SHORT_BRAND', 'Leamsoft'),

    'title_separator' => ' | ',
    'title_max'       => 62,  // Google truncates around here
    'desc_max'        => 158,
    'keyword_max'     => 25,  // keep the tag from looking spammy

    // Default social share image, relative to public/
    'default_image'   => env('SEO_DEFAULT_IMAGE', 'assets/images/leamsoft-og.jpg'),
    'twitter_handle'  => env('SEO_TWITTER_HANDLE', ''),

    /*
    |--------------------------------------------------------------------
    | Geo targeting
    |--------------------------------------------------------------------
    | Ordered by priority. "primary" cities are appended to titles and get
    | the strongest keyword permutations; "secondary" and "localities" only
    | feed the long-tail pool.
    |
    | Research note: NCR search behaviour is heavily hyperlocal -- sector
    | and locality qualifiers convert better than head terms.
    */
    'geo' => [
        'primary' => ['Noida', 'Delhi', 'Ghaziabad'],

        'secondary' => ['Greater Noida', 'Delhi NCR', 'Gurugram', 'Faridabad'],

        // Compact form for titles, where every character counts
        'short_phrase' => 'Noida & Delhi NCR',

        'localities' => [
            'Noida Sector 62',
            'Noida Sector 63',
            'Noida Sector 18',
            'Noida Sector 128',
            'Indirapuram',
            'Vaishali',
            'Vasundhara',
            'Raj Nagar Extension',
            'Crossings Republik',
            'Knowledge Park',
        ],

        // Used for geo meta tags and LocalBusiness schema
        'region'    => 'IN-UP',
        'placename' => 'Noida, Delhi NCR',
        'latitude'  => env('SEO_LATITUDE', '28.5355'),
        'longitude' => env('SEO_LONGITUDE', '77.3910'),
    ],

    /*
    |--------------------------------------------------------------------
    | Keyword templates
    |--------------------------------------------------------------------
    | {term} = the page subject, {city} = a geo value. Permuted against the
    | geo lists to build the long-tail keyword pool.
    */
    'templates' => [
        '{term} in {city}',
        '{term} company in {city}',
        'best {term} company in {city}',
        'top {term} services in {city}',
        '{term} services {city}',
        'affordable {term} in {city}',
        '{term} agency {city}',
        'hire {term} company {city}',
    ],

    /*
    |--------------------------------------------------------------------
    | Brand keywords -- merged into every page
    |--------------------------------------------------------------------
    */
    'base_keywords' => [
        'Leamsoft',
        'Leamsoft Pvt Ltd',
        'IT company in Noida',
        'software development company in Delhi NCR',
        'best IT company in Ghaziabad',
        'custom software development India',
    ],

    /*
    |--------------------------------------------------------------------
    | Service vocabulary
    |--------------------------------------------------------------------
    | Fallback pool for pages with no DB category attached (home, about,
    | contact). Mirrors the seeded category tree.
    */
    'service_terms' => [
        'software development',
        'web development',
        'mobile app development',
        'AI development',
        'machine learning',
        'cloud computing',
        'DevOps services',
        'cyber security',
        'digital marketing',
        'SEO services',
        'IT consulting',
        'ERP software',
        'CRM software',
        'SaaS development',
        'ecommerce development',
    ],

    /*
    |--------------------------------------------------------------------
    | Static page definitions
    |--------------------------------------------------------------------
    | Titles and descriptions support {brand} and {cities} placeholders.
    | "terms" drive the keyword generation for that page.
    */
    'pages' => [
        'home' => [
            'title'       => 'Software, AI & Cloud Company in {cities_short}',
            'description' => '{brand} builds AI-powered software, cloud platforms and mobile apps for businesses across Noida, Delhi and Ghaziabad. Talk to our team today.',
            'terms'       => ['software development', 'IT company', 'AI development', 'web development'],
        ],
        'about' => [
            'title'       => 'About Us - IT Company in {cities_short}',
            'description' => 'How {brand} helps startups and enterprises across Delhi NCR with custom software, AI automation, cloud migration and cyber security.',
            'terms'       => ['IT company', 'software company', 'technology consulting'],
        ],
        'services' => [
            'title'       => 'IT & Software Services in {cities_short}',
            'description' => 'Custom software, web and mobile development, AI/ML, cloud, DevOps, cyber security and digital marketing for clients across Noida, Delhi and Ghaziabad.',
            'terms'       => ['IT services', 'software development', 'web development', 'app development'],
        ],
        'contact' => [
            'title'       => 'Contact Us - Software Company in Noida',
            'description' => 'Get in touch with the {brand} team - call, email or send an enquiry and we will respond within one business day with a plan for your project.',
            'terms'       => ['contact software company', 'IT company near me', 'hire developers'],
        ],
        'blog' => [
            'title'       => 'Technology Blog - AI, Cloud & Software Insights',
            'description' => 'Practical articles on AI, cloud architecture, cyber security and software engineering from the {brand} team in Noida, Delhi NCR.',
            'terms'       => ['technology blog', 'software development blog', 'AI insights'],
        ],
        'gallery' => [
            'title'       => 'Our Work & Gallery',
            'description' => 'A look inside {brand} - our projects, our workspace in Noida, and the teams delivering software across Delhi NCR.',
            'terms'       => ['software company portfolio', 'IT company gallery'],
        ],
        'faq' => [
            'title'       => 'Frequently Asked Questions',
            'description' => 'Answers to common questions about working with {brand} - pricing, timelines, technology choices, support and engagement models.',
            'terms'       => ['software development FAQ', 'IT company questions'],
        ],
        'help' => [
            'title'       => 'Help & Support',
            'description' => 'Support resources and guidance for {brand} clients. Find answers or reach our Noida support team directly.',
            'terms'       => ['IT support', 'software support'],
        ],
        'near_by' => [
            'title'       => 'IT & Software Company Near You in {cities_short}',
            'description' => '{brand} serves clients across Noida, Greater Noida, Ghaziabad, Delhi, Gurugram and Faridabad. Find your nearest technology partner.',
            'terms'       => ['IT company near me', 'software company near me', 'web developer near me'],
        ],
        'privacy' => [
            'title'       => 'Privacy Policy',
            'description' => 'How {brand} collects, uses, stores and protects your personal data.',
            'terms'       => [],
        ],
        'terms' => [
            'title'       => 'Terms & Conditions',
            'description' => 'The terms governing use of the {brand} website and services.',
            'terms'       => [],
        ],
    ],
];
