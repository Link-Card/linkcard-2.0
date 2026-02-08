<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileView extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'profile_id',
        'ip_hash',
        'source',
        'referer_domain',
        'device_type',
        'viewed_at',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    /**
     * Détecter le type d'appareil depuis le user-agent
     */
    public static function detectDevice(?string $userAgent): string
    {
        if (!$userAgent) return 'unknown';

        $ua = strtolower($userAgent);

        if (str_contains($ua, 'tablet') || str_contains($ua, 'ipad')) {
            return 'tablet';
        }
        if (str_contains($ua, 'mobile') || str_contains($ua, 'android') || str_contains($ua, 'iphone')) {
            return 'mobile';
        }

        return 'desktop';
    }

    /**
     * Détecter la source de la visite
     */
    public static function detectSource(?string $referer, ?string $path = null): string
    {
        if (!$referer) return 'direct';

        $domain = strtolower(parse_url($referer, PHP_URL_HOST) ?? '');

        // Vient de notre propre site (QR popup, partage, etc.)
        if (str_contains($domain, 'linkcard.ca')) {
            return 'internal';
        }

        // Réseaux sociaux
        $socialDomains = ['linkedin.com', 'facebook.com', 'instagram.com', 'twitter.com', 'x.com', 'tiktok.com'];
        foreach ($socialDomains as $social) {
            if (str_contains($domain, $social)) return 'social';
        }

        // Moteurs de recherche
        $searchDomains = ['google.com', 'bing.com', 'yahoo.com', 'duckduckgo.com'];
        foreach ($searchDomains as $search) {
            if (str_contains($domain, $search)) return 'search';
        }

        return 'referral';
    }

    /**
     * Extraire le domaine du referer
     */
    public static function extractDomain(?string $referer): ?string
    {
        if (!$referer) return null;

        $host = parse_url($referer, PHP_URL_HOST);
        if (!$host) return null;

        // Retirer www.
        return preg_replace('/^www\./', '', strtolower($host));
    }
}
