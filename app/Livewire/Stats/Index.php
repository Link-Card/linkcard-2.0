<?php

namespace App\Livewire\Stats;

use Livewire\Component;
use App\Models\ProfileView;
use App\Models\LinkClick;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $profileId = null;
    public $period = '30'; // 7, 30, 90 jours
    public $profiles = [];

    public function mount()
    {
        $user = auth()->user();
        $this->profiles = $user->profiles()->get();

        if ($this->profiles->isNotEmpty()) {
            $this->profileId = $this->profiles->first()->id;
        }
    }

    public function updatedPeriod()
    {
        // Re-render automatique
    }

    public function updatedProfileId()
    {
        // Re-render automatique
    }

    public function exportCsv()
    {
        $user = auth()->user();
        if ($user->plan !== 'premium') {
            session()->flash('error', 'Export CSV disponible avec le forfait Premium.');
            return;
        }

        $profile = $user->profiles()->find($this->profileId);
        if (!$profile) return;

        $startDate = now()->subDays((int)$this->period);

        // Views data
        $views = ProfileView::where('profile_id', $profile->id)
            ->where('viewed_at', '>=', $startDate)
            ->orderBy('viewed_at', 'desc')
            ->get();

        // Clicks data
        $clicks = LinkClick::where('profile_id', $profile->id)
            ->where('clicked_at', '>=', $startDate)
            ->orderBy('clicked_at', 'desc')
            ->get();

        $csv = "Type,Date,Source/Plateforme,Appareil/URL\n";

        foreach ($views as $view) {
            $csv .= "Vue,{$view->viewed_at->format('Y-m-d H:i')},{$view->source},{$view->device_type}\n";
        }
        foreach ($clicks as $click) {
            $csv .= "Clic,{$click->clicked_at->format('Y-m-d H:i')},{$click->platform},{$click->url}\n";
        }

        $filename = "stats-{$profile->username}-" . now()->format('Y-m-d') . ".csv";

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function render()
    {
        $user = auth()->user();
        $plan = $user->plan ?? 'free';
        $profile = $user->profiles()->find($this->profileId);

        $data = [
            'plan' => $plan,
            'hasStats' => in_array($plan, ['pro', 'premium']),
            'isPremium' => $plan === 'premium',
            'totalViews' => 0,
            'periodViews' => 0,
            'dailyViews' => [],
            'sourceBreakdown' => [],
            'deviceBreakdown' => [],
            'topReferers' => [],
            'totalClicks' => 0,
            'clicksByPlatform' => [],
            'clicksByBand' => [],
            'profiles' => $this->profiles,
        ];

        if ($profile && in_array($plan, ['pro', 'premium'])) {
            $startDate = now()->subDays((int)$this->period);

            // Total vues all time
            $data['totalViews'] = $profile->view_count;

            // Vues sur la période
            $data['periodViews'] = ProfileView::where('profile_id', $profile->id)
                ->where('viewed_at', '>=', $startDate)
                ->count();

            // Vues par jour
            $dailyViews = ProfileView::where('profile_id', $profile->id)
                ->where('viewed_at', '>=', $startDate)
                ->select(DB::raw('DATE(viewed_at) as date'), DB::raw('COUNT(*) as count'))
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('count', 'date')
                ->toArray();

            // Remplir les jours manquants avec 0
            $days = (int)$this->period;
            $filledDays = [];
            for ($i = $days - 1; $i >= 0; $i--) {
                $date = now()->subDays($i)->format('Y-m-d');
                $filledDays[$date] = $dailyViews[$date] ?? 0;
            }
            $data['dailyViews'] = $filledDays;

            // Breakdown par source
            $data['sourceBreakdown'] = ProfileView::where('profile_id', $profile->id)
                ->where('viewed_at', '>=', $startDate)
                ->select('source', DB::raw('COUNT(*) as count'))
                ->groupBy('source')
                ->orderByDesc('count')
                ->pluck('count', 'source')
                ->toArray();

            // Breakdown par appareil
            $data['deviceBreakdown'] = ProfileView::where('profile_id', $profile->id)
                ->where('viewed_at', '>=', $startDate)
                ->select('device_type', DB::raw('COUNT(*) as count'))
                ->groupBy('device_type')
                ->orderByDesc('count')
                ->pluck('count', 'device_type')
                ->toArray();

            // Top referers
            $data['topReferers'] = ProfileView::where('profile_id', $profile->id)
                ->where('viewed_at', '>=', $startDate)
                ->whereNotNull('referer_domain')
                ->select('referer_domain', DB::raw('COUNT(*) as count'))
                ->groupBy('referer_domain')
                ->orderByDesc('count')
                ->limit(5)
                ->pluck('count', 'referer_domain')
                ->toArray();

            // PREMIUM: Clicks
            if ($plan === 'premium') {
                $data['totalClicks'] = LinkClick::where('profile_id', $profile->id)
                    ->where('clicked_at', '>=', $startDate)
                    ->count();

                $data['clicksByPlatform'] = LinkClick::where('profile_id', $profile->id)
                    ->where('clicked_at', '>=', $startDate)
                    ->whereNotNull('platform')
                    ->select('platform', DB::raw('COUNT(*) as count'))
                    ->groupBy('platform')
                    ->orderByDesc('count')
                    ->pluck('count', 'platform')
                    ->toArray();

                // Clics par bande (avec info)
                $data['clicksByBand'] = LinkClick::where('link_clicks.profile_id', $profile->id)
                    ->where('clicked_at', '>=', $startDate)
                    ->join('content_bands', 'link_clicks.content_band_id', '=', 'content_bands.id')
                    ->select(
                        'content_bands.id',
                        'content_bands.type',
                        'content_bands.data',
                        DB::raw('COUNT(*) as count')
                    )
                    ->groupBy('content_bands.id', 'content_bands.type', 'content_bands.data')
                    ->orderByDesc('count')
                    ->limit(10)
                    ->get()
                    ->map(function ($item) {
                        $data = is_string($item->data) ? json_decode($item->data, true) : $item->data;
                        return [
                            'type' => $item->type,
                            'label' => $item->type === 'social_link'
                                ? ucfirst($data['platform'] ?? 'Lien')
                                : ($data['images'][0]['link'] ?? 'Image'),
                            'count' => $item->count,
                        ];
                    })
                    ->toArray();
            }
        }

        return view('livewire.stats.index', $data)->layout('layouts.dashboard');
    }
}
