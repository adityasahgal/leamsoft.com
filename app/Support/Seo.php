<?php

namespace App\Support;

/**
 * Builds page meta (title, description, keywords, social tags, schema)
 * from config/seo.php plus whatever the page is actually about.
 *
 * Two entry points:
 *   Seo::page('home')            -- static pages defined in config
 *   Seo::model($category, ...)   -- DB-backed pages (category, service, blog)
 *
 * Both return an array consumed by layouts/master.blade.php. Anything the
 * admin has typed into the DB meta fields always wins over generated text.
 */
class Seo
{
    /**
     * Meta for a static page key defined in config('seo.pages').
     */
    public static function page(string $key, array $overrides = []): array
    {
        $page = config("seo.pages.{$key}", []);

        $title = self::fill($page['title'] ?? '');
        $desc  = self::fill($page['description'] ?? '');

        $keywords = self::keywords($page['terms'] ?? []);

        return self::finalise(array_merge([
            'title'       => $title,
            'description' => $desc,
            'keywords'    => $keywords,
            'type'        => 'website',
        ], $overrides));
    }

    /**
     * Meta for a DB record (Category, Subcategory, Service or Blog).
     *
     * Admin-entered meta_title / meta_description / keywords take priority;
     * anything left blank is generated from the record name plus geo terms.
     *
     * @param  object  $row      the Eloquent model
     * @param  string  $subject  noun used in generated copy, e.g. "Services"
     */
    public static function model($row, string $subject = 'Services', array $overrides = []): array
    {
        $name = trim($row->name ?? '');

        // Title: admin value, else "<Name> in Noida, Delhi & Ghaziabad"
        $title = trim($row->meta_title ?? '');
        if ($title === '') {
            $title = $name !== ''
                ? $name . ' in ' . self::cityPhrase()
                : self::fill(config('seo.pages.services.title', ''));
        }

        // Description: admin value, else short_description, else generated
        $desc = trim($row->meta_description ?? '');
        $fromAdmin = $desc !== '';
        if ($desc === '') {
            $desc = trim(strip_tags($row->short_description ?? ''));
        }
        if ($fromAdmin) {
            // Hand-written meta description: use it exactly as entered
        } elseif ($desc === '' && $name !== '') {
            $desc = sprintf(
                'Professional %s %s from %s. Serving businesses across Noida, Delhi, Ghaziabad and the wider Delhi NCR region.',
                $name,
                strtolower($subject),
                config('seo.brand')
            );
        } elseif ($name !== '' && mb_strlen($desc) < 110 && $subject !== 'Articles') {
            // A one-liner like "Image & video understanding." is too thin
            // for a snippet; lead with the name and add who/where.
            $lead = stripos($desc, $name) === false ? $name . ': ' . rtrim($desc, '. ') : rtrim($desc, '. ');
            $desc = sprintf('%s. Delivered by %s for businesses in %s', $lead, config('seo.short_brand'), self::cityPhrase());
            $desc .= mb_strlen($desc) + 17 <= config('seo.desc_max', 158) ? ' and across India.' : '.';
        }

        // Keywords: admin list first, then generated permutations of the name
        $seed = self::splitList($row->keywords ?? '');
        $terms = $name !== '' ? [$name] : [];

        return self::finalise(array_merge([
            'title'       => $title,
            'description' => $desc,
            'keywords'    => self::keywords($terms, $seed),
            'type'        => 'website',
            'image'       => self::shareImage($row),
            'image_alt'   => trim($row->image_alt ?? '') ?: $name,
        ], $overrides));
    }

    /**
     * Social share image for a record: blog banner, then thumbnail. SVG is
     * skipped -- Facebook, LinkedIn and WhatsApp don't render it -- so those
     * records fall back to the site default image.
     */
    public static function shareImage($row): ?string
    {
        foreach (['banner', 'thumbnail_img', 'image'] as $field) {
            $path = $row->{$field} ?? null;
            if (empty($path) || str_ends_with(strtolower($path), '.svg')) {
                continue;
            }
            if (file_exists(storage_path('app/public/' . $path))) {
                return url('storage/' . $path);
            }
        }

        return null;
    }

    /**
     * Meta for a single blog post -- same rules as model(), but emits
     * article-type social tags and published/modified timestamps.
     */
    public static function article($row, array $overrides = []): array
    {
        $meta = self::model($row, 'Articles', [
            'type' => 'article',
        ]);

        $meta['published_time'] = optional($row->created_at)->toIso8601String();
        $meta['modified_time']  = optional($row->updated_at)->toIso8601String();

        return array_merge($meta, $overrides);
    }

    /*
    |--------------------------------------------------------------------
    | Keyword generation
    |--------------------------------------------------------------------
    */

    /**
     * Build the keyword pool for a page.
     *
     * Order matters -- the list is trimmed to seo.keyword_max, so the most
     * valuable keywords are added first:
     *   1. admin-supplied keywords (highest intent, hand-picked)
     *   2. the bare page terms
     *   3. term x primary city permutations
     *   4. term x secondary city permutations
     *   5. hyperlocal sector/locality variants
     *   6. brand keywords
     *
     * @param  array  $terms  page subjects, e.g. ["web development"]
     * @param  array  $seed   admin-entered keywords to place first
     */
    public static function keywords(array $terms, array $seed = []): array
    {
        $geo = config('seo.geo');
        $templates = config('seo.templates', []);

        // Fall back to the general service vocabulary for term-less pages
        if (empty($terms)) {
            $terms = array_slice(config('seo.service_terms', []), 0, 4);
        }

        $out = $seed;

        foreach ($terms as $term) {
            $out[] = $term;
        }

        // Primary cities, template-major order. Iterating templates on the
        // outside means the strongest pattern is generated for *every*
        // term/city pair before the weaker patterns start -- so the
        // keyword_max trim cuts low-value variants, not whole cities.
        foreach ($templates as $tpl) {
            foreach ($geo['primary'] as $city) {
                foreach ($terms as $term) {
                    $out[] = self::apply($tpl, $term, $city);
                }
            }
        }

        // Secondary cities get only the two strongest patterns
        foreach (['{term} in {city}', '{term} company in {city}'] as $tpl) {
            foreach ($geo['secondary'] as $city) {
                foreach ($terms as $term) {
                    $out[] = self::apply($tpl, $term, $city);
                }
            }
        }

        // Hyperlocal -- only the lead term, to keep the list focused
        $lead = $terms[0] ?? null;
        if ($lead) {
            foreach ($geo['localities'] as $spot) {
                $out[] = self::apply('{term} in {city}', $lead, $spot);
            }
        }

        foreach (config('seo.base_keywords', []) as $kw) {
            $out[] = $kw;
        }

        return self::dedupe($out);
    }

    /*
    |--------------------------------------------------------------------
    | Structured data
    |--------------------------------------------------------------------
    */

    /**
     * Organization + LocalBusiness graph for the site.
     *
     * @param  object|null  $setting  the Setting row, for address/phone/socials
     */
    public static function organizationSchema($setting = null): array
    {
        $geo = config('seo.geo');

        $socials = array_values(array_filter([
            $setting->facebook  ?? null,
            $setting->twitter   ?? null,
            $setting->linkedin  ?? null,
            $setting->instagram ?? null,
            $setting->youtube   ?? null,
        ]));

        $node = [
            '@context'    => 'https://schema.org',
            '@type'       => 'ProfessionalService',
            '@id'         => url('/') . '#organization',
            'name'        => config('seo.brand'),
            'url'         => url('/'),
            'description' => self::fill(config('seo.pages.home.description', '')),
            'areaServed'  => array_map(
                fn ($c) => ['@type' => 'City', 'name' => $c],
                array_merge($geo['primary'], $geo['secondary'])
            ),
            'geo' => [
                '@type'     => 'GeoCoordinates',
                'latitude'  => $geo['latitude'],
                'longitude' => $geo['longitude'],
            ],
        ];

        if (!empty($setting->logo)) {
            $node['logo'] = url('storage/' . $setting->logo);
            $node['image'] = $node['logo'];
        }
        if (!empty($setting->phone)) {
            $node['telephone'] = $setting->phone;
        }
        if (!empty($setting->email)) {
            $node['email'] = $setting->email;
        }
        $addr = config('seo.address');
        if (!empty($addr['street'])) {
            $node['address'] = [
                '@type'           => 'PostalAddress',
                'streetAddress'   => $addr['street'],
                'addressLocality' => $addr['locality'],
                'addressRegion'   => $addr['region'],
                'postalCode'      => $addr['postcode'],
                'addressCountry'  => $addr['country'],
            ];
        } elseif (!empty($setting->address)) {
            $node['address'] = [
                '@type'          => 'PostalAddress',
                'streetAddress'  => $setting->address,
                'addressCountry' => 'IN',
            ];
        }
        if (config('seo.opening_hours')) {
            $node['openingHours'] = config('seo.opening_hours');
        }
        if (!empty($setting->phone) || !empty($setting->email)) {
            $node['contactPoint'] = array_filter([
                '@type'             => 'ContactPoint',
                'contactType'       => 'sales',
                'telephone'         => $setting->phone ?? null,
                'email'             => $setting->email ?? null,
                'areaServed'        => 'IN',
                'availableLanguage' => ['English', 'Hindi'],
            ]);
        }
        if ($socials) {
            $node['sameAs'] = $socials;
        }

        return $node;
    }

    /**
     * WebSite node -- tells search engines the site name and publisher.
     */
    public static function websiteSchema(): array
    {
        return [
            '@context'   => 'https://schema.org',
            '@type'      => 'WebSite',
            '@id'        => url('/') . '#website',
            'url'        => url('/'),
            'name'       => config('seo.short_brand'),
            'alternateName' => config('seo.brand'),
            'inLanguage' => 'en-IN',
            'publisher'  => ['@id' => url('/') . '#organization'],
        ];
    }

    /**
     * BlogPosting for a single post.
     */
    public static function articleSchema($blog, array $meta): array
    {
        $url = url('blog/' . $blog->slug);
        $image = !empty($blog->banner) ? url('storage/' . $blog->banner) : $meta['image'];
        $words = str_word_count(strip_tags((string) $blog->description));

        return [
            '@context'         => 'https://schema.org',
            '@type'            => 'BlogPosting',
            '@id'              => $url . '#article',
            'mainEntityOfPage' => $url,
            'headline'         => self::trim($blog->name, 110),
            'description'      => $meta['description'],
            'image'            => [$image],
            'datePublished'    => optional($blog->created_at)->toIso8601String(),
            'dateModified'     => optional($blog->updated_at ?? $blog->created_at)->toIso8601String(),
            'wordCount'        => $words,
            'keywords'         => self::splitList($blog->keywords ?? ''),
            'inLanguage'       => 'en-IN',
            'author'           => ['@type' => 'Organization', 'name' => config('seo.brand'), 'url' => url('/')],
            'publisher'        => ['@id' => url('/') . '#organization'],
            'isPartOf'         => ['@id' => url('/') . '#website'],
        ];
    }

    /**
     * Service node for a category, subcategory or service page.
     */
    public static function serviceSchema($row, string $url, ?string $category = null): array
    {
        $geo = config('seo.geo');

        return array_filter([
            '@context'    => 'https://schema.org',
            '@type'       => 'Service',
            '@id'         => $url . '#service',
            'name'        => $row->name,
            'serviceType' => $category ?: $row->name,
            'description' => self::trim(strip_tags((string) ($row->short_description ?: $row->meta_description ?? '')), 300) ?: null,
            'url'         => $url,
            'image'       => self::shareImage($row),
            'provider'    => ['@id' => url('/') . '#organization'],
            'areaServed'  => array_map(
                fn ($c) => ['@type' => 'City', 'name' => $c],
                array_merge($geo['primary'], $geo['secondary'])
            ),
        ]);
    }

    /**
     * BreadcrumbList from an ordered [label => url] map.
     */
    public static function breadcrumbSchema(array $trail): array
    {
        $items = [];
        $position = 1;

        foreach ($trail as $label => $url) {
            $items[] = [
                '@type'    => 'ListItem',
                'position' => $position++,
                'name'     => $label,
                'item'     => $url,
            ];
        }

        return [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $items,
        ];
    }

    /*
    |--------------------------------------------------------------------
    | Internals
    |--------------------------------------------------------------------
    */

    /** Replace {brand} and {cities} placeholders. */
    private static function fill(string $text): string
    {
        return strtr($text, [
            '{brand}'        => config('seo.brand'),
            '{cities}'       => self::cityPhrase(),
            '{cities_short}' => config('seo.geo.short_phrase', 'Noida & Delhi NCR'),
        ]);
    }

    /** "Noida, Delhi & Ghaziabad" */
    private static function cityPhrase(): string
    {
        $cities = config('seo.geo.primary', []);

        if (count($cities) < 2) {
            return $cities[0] ?? '';
        }

        $last = array_pop($cities);

        return implode(', ', $cities) . ' & ' . $last;
    }

    /**
     * Render one template, or return '' if it would read badly.
     *
     * Category names already carry nouns like "company", "services" or
     * "development" -- blindly applying every template produces junk such as
     * "software development company company in Noida". When the term already
     * contains the template's own noun, the variant is dropped.
     */
    private static function apply(string $template, string $term, string $city): string
    {
        $lowerTerm = mb_strtolower($term);

        foreach (['company', 'services', 'service', 'agency'] as $noun) {
            if (str_contains($template, $noun) && str_contains($lowerTerm, $noun)) {
                return '';
            }
        }

        return strtr($template, ['{term}' => $term, '{city}' => $city]);
    }

    /**
     * Truncate on a word boundary so titles and descriptions never end
     * mid-word. Returns the string untouched when it already fits.
     */
    private static function trim(string $text, int $max): string
    {
        $text = trim(preg_replace('/\s+/', ' ', $text));

        if (mb_strlen($text) <= $max) {
            return $text;
        }

        $cut = mb_substr($text, 0, $max);
        $lastSpace = mb_strrpos($cut, ' ');

        if ($lastSpace !== false && $lastSpace > $max * 0.6) {
            $cut = mb_substr($cut, 0, $lastSpace);
        }

        return rtrim($cut, " ,.-&|");
    }

    /** Split a comma-separated admin keyword string into a clean array. */
    private static function splitList(?string $raw): array
    {
        if (!$raw) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', $raw))));
    }

    /** Case-insensitive dedupe, preserving first-seen order. */
    private static function dedupe(array $items): array
    {
        $seen = [];
        $out  = [];

        foreach ($items as $item) {
            $item = trim(preg_replace('/\s+/', ' ', (string) $item));
            if ($item === '') {
                continue;
            }

            $key = mb_strtolower($item);
            if (isset($seen[$key])) {
                continue;
            }

            $seen[$key] = true;
            $out[] = $item;
        }

        return $out;
    }

    /**
     * Apply length limits and fill in defaults that every page needs.
     */
    private static function finalise(array $meta): array
    {
        $brand = config('seo.brand');
        $sep   = config('seo.title_separator', ' | ');

        $short = config('seo.short_brand', 'Leamsoft');
        $max   = config('seo.title_max', 62);

        $title = trim($meta['title'] ?? '') ?: $brand;

        // Append the brand only if it is not already there and it still fits.
        // Trimming the subject to make room for the brand would be a bad
        // trade -- the subject is what people search for.
        if (stripos($title, $short) === false) {
            $suffix = $sep . $short;
            if (mb_strlen($title) + mb_strlen($suffix) <= $max) {
                $title .= $suffix;
            }
        }

        $meta['title'] = self::trim($title, $max);

        $meta['description'] = self::trim(
            strip_tags($meta['description'] ?? ''),
            config('seo.desc_max', 158)
        );

        $keywords = $meta['keywords'] ?? [];
        $meta['keywords'] = array_slice($keywords, 0, config('seo.keyword_max', 25));

        // Paginated listings: page 2+ is its own canonical page, otherwise
        // Google treats everything past page 1 as a duplicate and drops it.
        $page = (int) request()->query('page', 1);
        if (empty($meta['canonical'])) {
            $meta['canonical'] = url()->current() . ($page > 1 ? '?page=' . $page : '');
        }
        if ($page > 1 && !str_contains($meta['title'], 'Page ' . $page)) {
            $meta['title'] = self::trim($meta['title'], $max - 9) . ' – Page ' . $page;
        }

        $meta['type']      = $meta['type'] ?? 'website';
        $meta['robots']    = $meta['robots'] ?? 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1';

        if (empty($meta['image'])) {
            $meta['image'] = url(config('seo.default_image'));
            [$meta['image_width'], $meta['image_height']] = config('seo.default_image_size', [1200, 630]);
            $meta['image_alt'] = $brand;
        }
        $meta['image_alt'] = $meta['image_alt'] ?? $meta['title'];

        return $meta;
    }
}
