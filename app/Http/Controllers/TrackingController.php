<?php

namespace App\Http\Controllers;

use App\Models\LinkClick;
use App\Models\ContentBand;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    /**
     * Track a link click (appelé via JS fetch depuis le profil public)
     */
    public function trackClick(Request $request)
    {
        $request->validate([
            'band_id' => 'required|integer',
            'url' => 'nullable|string|max:500',
        ]);

        try {
            $band = ContentBand::find($request->band_id);
            if (!$band) {
                return response()->json(['ok' => false], 404);
            }

            $ipHash = hash('sha256', $request->ip() . config('app.key'));

            // Déduplication: même IP + même bande = 1 clic par 5 minutes
            $recentClick = LinkClick::where('content_band_id', $band->id)
                ->where('ip_hash', $ipHash)
                ->where('clicked_at', '>', now()->subMinutes(5))
                ->exists();

            if (!$recentClick) {
                $platform = null;
                if ($band->type === 'social_link') {
                    $platform = $band->data['platform'] ?? null;
                }

                LinkClick::create([
                    'profile_id' => $band->profile_id,
                    'content_band_id' => $band->id,
                    'platform' => $platform,
                    'url' => $request->url,
                    'ip_hash' => $ipHash,
                    'clicked_at' => now(),
                ]);
            }

            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            return response()->json(['ok' => false], 500);
        }
    }
}
