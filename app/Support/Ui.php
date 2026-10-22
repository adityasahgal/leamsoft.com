<?php

namespace App\Support;

use Illuminate\Support\Str;

/**
 * Small presentation helpers for the frontend views.
 */
class Ui
{
    /**
     * Keyword => sprite icon id. First match wins, so more specific
     * keywords sit above generic ones.
     */
    private const ICONS = [
        'ai'         => 'i-ai',
        'machine'    => 'i-ai',
        'intellig'   => 'i-ai',
        'automat'    => 'i-ai',
        'cloud'      => 'i-cloud',
        'devops'     => 'i-cloud',
        'hosting'    => 'i-cloud',
        'secur'      => 'i-shield',
        'cyber'      => 'i-shield',
        'block'      => 'i-grid',
        'web3'       => 'i-grid',
        'marketing'  => 'i-growth',
        'seo'        => 'i-growth',
        'social'     => 'i-growth',
        'consult'    => 'i-compass',
        'strategy'   => 'i-compass',
        'mobile'     => 'i-phone',
        'app'        => 'i-phone',
        'crm'        => 'i-users',
        'erp'        => 'i-users',
        'saas'       => 'i-rocket',
        'product'    => 'i-rocket',
        'design'     => 'i-monitor',
        'ui'         => 'i-monitor',
        'ecommerce'  => 'i-cart',
        'e-commerce' => 'i-cart',
        'data'       => 'i-file',
        'support'    => 'i-chat',
    ];

    /**
     * Pick a sprite icon for a category / service name.
     */
    public static function icon(?string $name, string $fallback = 'i-code'): string
    {
        $haystack = ' ' . Str::lower((string) $name) . ' ';

        foreach (self::ICONS as $needle => $icon) {
            // Short keywords (ai, ui, seo) must match a whole word
            $hit = strlen($needle) <= 3
                ? preg_match('/[^a-z]' . preg_quote($needle, '/') . '[^a-z]/', $haystack)
                : str_contains($haystack, $needle);

            if ($hit) {
                return $icon;
            }
        }

        return $fallback;
    }

    /**
     * Public URL of the site logo with its empty background trimmed off.
     *
     * Uploaded logos often sit in a large canvas (the current one is a
     * 1536x1024 image with the badge in the middle), which makes them tiny
     * at header size. The first request builds a trimmed copy next to the
     * original; later requests just reuse it. Falls back to the original
     * when GD is missing or nothing can be trimmed.
     */
    public static function logoUrl($setting): ?string
    {
        $path = $setting->logo ?? ($setting['logo'] ?? null);
        if (empty($path)) {
            return null;
        }

        $src = storage_path('app/public/' . $path);
        if (!is_file($src)) {
            return null;
        }

        $trimmedRel = dirname($path) . '/trim-' . pathinfo($path, PATHINFO_FILENAME) . '.png';
        $trimmed = storage_path('app/public/' . $trimmedRel);

        if (is_file($trimmed) && filemtime($trimmed) >= filemtime($src)) {
            return url('storage/' . $trimmedRel);
        }

        return self::trimImage($src, $trimmed)
            ? url('storage/' . $trimmedRel)
            : url('storage/' . $path);
    }

    /**
     * Crop away the border colour (sampled from the corners) around an
     * image, keeping a little breathing room. Returns false if GD is
     * unavailable or the image has no clear border to remove.
     */
    private static function trimImage(string $src, string $dest): bool
    {
        if (!function_exists('imagecreatefromstring')) {
            return false;
        }

        $img = @imagecreatefromstring((string) file_get_contents($src));
        if (!$img) {
            return false;
        }

        $w = imagesx($img);
        $h = imagesy($img);

        // Background = average of the four corners
        $bg = [0, 0, 0];
        foreach ([[0, 0], [$w - 1, 0], [0, $h - 1], [$w - 1, $h - 1]] as [$x, $y]) {
            $c = imagecolorsforindex($img, imagecolorat($img, $x, $y));
            $bg[0] += $c['red'] / 4;
            $bg[1] += $c['green'] / 4;
            $bg[2] += $c['blue'] / 4;
        }

        // Dark backgrounds often carry a soft vignette, so "different from
        // the corners" isn't enough there: count only clearly bright or
        // clearly coloured pixels. Light backgrounds use plain distance.
        $bgLuma = ($bg[0] + $bg[1] + $bg[2]) / 3;
        $isContent = function (int $x, int $y) use ($img, $bg, $bgLuma): bool {
            $c = imagecolorsforindex($img, imagecolorat($img, $x, $y));
            if ($c['alpha'] > 100) {
                return false; // mostly transparent
            }
            $max = max($c['red'], $c['green'], $c['blue']);
            $min = min($c['red'], $c['green'], $c['blue']);
            if ($bgLuma < 80) {
                return $max > 150 || ($max - $min > 110 && $max > 110);
            }
            return abs($c['red'] - $bg[0]) + abs($c['green'] - $bg[1]) + abs($c['blue'] - $bg[2]) > 120;
        };

        // Scan on a coarse grid first -- plenty accurate for a crop box
        $step = max(1, (int) floor(min($w, $h) / 400));
        $minX = $w; $minY = $h; $maxX = -1; $maxY = -1;
        for ($y = 0; $y < $h; $y += $step) {
            for ($x = 0; $x < $w; $x += $step) {
                if ($isContent($x, $y)) {
                    $minX = min($minX, $x); $maxX = max($maxX, $x);
                    $minY = min($minY, $y); $maxY = max($maxY, $y);
                }
            }
        }

        if ($maxX < 0) {
            imagedestroy($img);
            return false;
        }

        $pad = (int) round(($maxY - $minY) * 0.04);
        $minX = max(0, $minX - $pad);
        $minY = max(0, $minY - $pad);
        $maxX = min($w - 1, $maxX + $pad);
        $maxY = min($h - 1, $maxY + $pad);
        $cw = $maxX - $minX + 1;
        $ch = $maxY - $minY + 1;

        // Nothing meaningful to trim
        if ($cw * $ch > $w * $h * 0.9) {
            imagedestroy($img);
            return false;
        }

        // Keep the file light: header logos never need more than ~120px tall (3x of 40px)
        $scale = min(1, 120 / $ch);
        $ow = (int) round($cw * $scale);
        $oh = (int) round($ch * $scale);

        $out = imagecreatetruecolor($ow, $oh);
        imagealphablending($out, false);
        imagesavealpha($out, true);
        imagecopyresampled($out, $img, 0, 0, $minX, $minY, $ow, $oh, $cw, $ch);

        @mkdir(dirname($dest), 0775, true);
        $ok = imagepng($out, $dest, 9);

        imagedestroy($img);
        imagedestroy($out);

        return (bool) $ok;
    }

    /**
     * One-line company description: the admin setting when it is a real
     * sentence, otherwise the standard positioning line.
     */
    public static function siteDescription($setting = null): string
    {
        $text = trim(strip_tags((string) ($setting->description ?? '')));

        return mb_strlen($text) >= 40
            ? $text
            : 'Leamsoft Pvt Ltd. designs, builds and runs AI-powered software, cloud platforms and mobile apps for startups and enterprises across Delhi NCR and India.';
    }

    /**
     * Plain-text excerpt from possibly-HTML content.
     */
    public static function excerpt(?string $text, int $limit = 140): string
    {
        $plain = trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags((string) $text))));

        return Str::limit($plain, $limit);
    }

    /**
     * Wrap the last $words words of a heading in a muted span, the way the
     * design splits "Software that runs <dim>modern businesses.</dim>".
     */
    public static function dimTail(string $text, int $words = 2): string
    {
        $parts = preg_split('/\s+/', trim($text));

        if (count($parts) <= $words) {
            return e($text);
        }

        $tail = array_splice($parts, -$words);

        return e(implode(' ', $parts)) . ' <span class="dim">' . e(implode(' ', $tail)) . '</span>';
    }
}
