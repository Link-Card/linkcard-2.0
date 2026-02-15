<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <title>{{ $profile->full_name }} - Link-Card</title>
    
    <!-- Open Graph -->
    <meta property="og:title" content="{{ $profile->full_name }} - Link-Card">
    <meta property="og:description" content="{{ $profile->job_title }}{{ $profile->company ? ' @ '.$profile->company : '' }}">
    @if($profile->photo_path)
        <meta property="og:image" content="{{ Storage::url($profile->photo_path) }}">
    @endif
    <meta property="og:type" content="profile">
    <meta property="og:url" content="{{ url()->current() }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Manrope', system-ui, -apple-system, sans-serif; }
        
        /* Share Button — uses profile primary color via CSS variable set in body */
        .share-btn {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--share-color, #42B574);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px color-mix(in srgb, var(--share-color, #42B574) 40%, transparent);
        }
        .share-btn:hover { 
            transform: scale(1.05); 
            filter: brightness(0.9);
            box-shadow: 0 4px 12px color-mix(in srgb, var(--share-color, #42B574) 50%, transparent);
        }
        .share-btn svg { width: 20px; height: 20px; fill: white; }
        
        /* Overlay */
        .share-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 50;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .share-overlay.active { display: flex; }
        
        /* Popup */
        .share-popup {
            background: white;
            border-radius: 20px;
            padding: 24px;
            width: 100%;
            max-width: 340px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            animation: popupIn 0.2s ease-out;
        }
        @keyframes popupIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        
        /* Toast */
        .toast {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: #2C2A27;
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 60;
            transition: transform 0.3s ease;
        }
        .toast.show { transform: translateX(-50%) translateY(0); }
        .toast svg { width: 18px; height: 18px; fill: #7EE081; }
        
        /* Animated waves (from v1) */
        .waves-container {
            position: relative;
            width: 100%;
            height: 60px;
            margin-bottom: -2px;
            overflow: hidden;
        }
        .waves-container svg {
            display: block;
            width: 100%;
            height: 100%;
        }
        .waves-container .parallax > use {
            animation: wave-move 25s cubic-bezier(.55,.5,.45,.5) infinite;
        }
        .waves-container .parallax > use:nth-child(1) {
            animation-delay: -2s;
            animation-duration: 7s;
        }
        .waves-container .parallax > use:nth-child(2) {
            animation-delay: -3s;
            animation-duration: 10s;
        }
        .waves-container .parallax > use:nth-child(3) {
            animation-delay: -4s;
            animation-duration: 13s;
        }
        .waves-container .parallax > use:nth-child(4) {
            animation-delay: -5s;
            animation-duration: 20s;
        }
        @keyframes wave-move {
            0% { transform: translate3d(-90px,0,0); }
            100% { transform: translate3d(85px,0,0); }
        }
    </style>
    @livewireStyles
</head>
<body class="min-h-screen" style="background: #F7F8F4;">

    @php
        $primaryColor = preg_match('/^#[a-fA-F0-9]{6}$/', $profile->primary_color ?? '') ? $profile->primary_color : '#42B574';
        $secondaryColor = preg_match('/^#[a-fA-F0-9]{6}$/', $profile->secondary_color ?? '') ? $profile->secondary_color : '#2D7A4F';
        $profileUrl = url()->current();
        $userPlan = auth()->check() ? (auth()->user()->plan ?? 'free') : 'free';
        $canShowQR = in_array($userPlan, ['pro', 'premium']) || (auth()->check() && auth()->user()->role === 'super_admin');
        
        // Connection status
        $isOwnProfile = auth()->check() && auth()->id() === $profile->user_id;
        $connectionStatus = null; // null, 'pending_sent', 'pending_received', 'accepted'
        if (auth()->check() && !$isOwnProfile) {
            $connection = \App\Services\ConnectionService::getConnectionBetween(auth()->id(), $profile->user_id);
            if ($connection) {
                if ($connection->status === 'accepted') {
                    $connectionStatus = 'accepted';
                } elseif ($connection->status === 'pending') {
                    $connectionStatus = $connection->sender_id === auth()->id() ? 'pending_sent' : 'pending_received';
                }
            }
        }
        
        // Template resolution
        $templateSlug = $profile->template_id ?? 'classic';
        $templateConfig = $profile->getEffectiveTemplateConfig();
        $headerStyle = $templateConfig['header_style'] ?? 'classic';
        $templateTransition = $templateConfig['transition'] ?? 'wave';
        $buttonStyle = $templateConfig['button_style'] ?? 'rounded';
        $socialStyle = $templateConfig['social_style'] ?? 'pills';
        
        // Button CSS classes based on template button_style
        $btnRadius = match($buttonStyle) {
            'square' => 'rounded-md',
            'square_wide' => 'rounded-none',
            'outline_compact' => 'rounded-full',
            default => 'rounded-xl',
        };
        
        // Calculer si le texte doit être clair ou foncé
        $hex = ltrim($primaryColor, '#');
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
        $headerTextColor = $luminance > 0.6 ? '#2C2A27' : '#FFFFFF';
        
        // Available header partials
        $validHeaders = ['classic', 'wave', 'minimal', 'diagonal', 'arch', 'split', 'banner', 'geometric', 'bold', 'videaste', 'artiste', 'entrepreneur'];
        $headerPartial = in_array($headerStyle, $validHeaders) ? $headerStyle : 'classic';
    @endphp

    <style>:root { --share-color: {{ $primaryColor }}; }</style>

    @php
        $isBoldTemplate = ($headerStyle === 'bold');
        $bodyBg = $isBoldTemplate ? '#E8E6E3' : 'white';
        $blockBg = $isBoldTemplate ? '#DFDDD9' : '#F9FAFB';
        $blockBorder = $isBoldTemplate ? ($primaryColor . '50') : '#E5E7EB';
    @endphp

    <div class="max-w-md mx-auto min-h-screen relative" style="background: {{ $bodyBg }};">

        <!-- HEADER (Template: {{ $headerPartial }}) -->
        @include('profiles.partials.headers.' . $headerPartial)

        <!-- TRANSITION (centralisée, sauf banner qui a la sienne interne) -->
        @if($headerPartial !== 'banner')
            @include('profiles.partials.transition', ['transition' => $templateTransition, 'fillColor' => $bodyBg])
        @endif

        <!-- CONTENT BANDS -->
        <div class="min-h-[200px]">
            <div class="px-5 py-6 space-y-3">

                @php
                    $visibleBands = $profile->contentBands->where('is_hidden', false)->sortBy('order')->values();
                    $renderedSocialIds = [];
                @endphp

                @foreach($visibleBands as $band)

                    @if($band->type === 'contact_button')
                        <!-- Bouton Ajouter au contact → ouvre popup -->
                        @if($buttonStyle === 'outline_compact')
                            <div class="text-center">
                                <button onclick="openContactPopup()"
                                   class="inline-flex items-center justify-center space-x-2 py-2.5 px-8 text-center rounded-full font-semibold text-sm transition-all duration-200"
                                   style="background: transparent; color: {{ $secondaryColor }}; border: 2px solid {{ $secondaryColor }};"
                                   onmouseover="this.style.background='{{ $secondaryColor }}'; this.style.color='white'"
                                   onmouseout="this.style.background='transparent'; this.style.color='{{ $secondaryColor }}'">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-8 2.75c1.24 0 2.25 1.01 2.25 2.25s-1.01 2.25-2.25 2.25S9.75 10.24 9.75 9s1.01-2.25 2.25-2.25zM17 17H7v-1.5c0-1.67 3.33-2.5 5-2.5s5 .83 5 2.5V17z"/></svg>
                                    <span>Ajouter aux contacts</span>
                                </button>
                            </div>
                        @else
                            <button onclick="openContactPopup()"
                               class="flex items-center justify-center space-x-2 w-full {{ $buttonStyle === 'square_wide' ? 'py-3.5 px-5' : 'py-3 px-5' }} text-white text-center {{ $btnRadius }} font-semibold {{ $buttonStyle === 'square_wide' ? 'text-base tracking-wide' : 'text-sm' }} shadow-sm transition-all duration-200"
                               style="background: {{ $secondaryColor }};"
                               onmouseover="this.style.opacity='0.9'; this.style.transform='translateY(-1px)'"
                               onmouseout="this.style.opacity='1'; this.style.transform='translateY(0)'">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-8 2.75c1.24 0 2.25 1.01 2.25 2.25s-1.01 2.25-2.25 2.25S9.75 10.24 9.75 9s1.01-2.25 2.25-2.25zM17 17H7v-1.5c0-1.67 3.33-2.5 5-2.5s5 .83 5 2.5V17z"/></svg>
                                <span>Ajouter aux contacts</span>
                            </button>
                        @endif

                    @elseif($band->type === 'social_link')
                        @if(!in_array($band->id, $renderedSocialIds ?? []))
                            @php
                                // Collect consecutive social links starting from this band
                                $renderedSocialIds = $renderedSocialIds ?? [];
                                $consecutiveSocials = collect();
                                $foundCurrent = false;
                                foreach ($visibleBands as $checkBand) {
                                    if ($checkBand->id === $band->id) {
                                        $foundCurrent = true;
                                        $consecutiveSocials->push($checkBand);
                                        $renderedSocialIds[] = $checkBand->id;
                                    } elseif ($foundCurrent && $checkBand->type === 'social_link') {
                                        $consecutiveSocials->push($checkBand);
                                        $renderedSocialIds[] = $checkBand->id;
                                    } elseif ($foundCurrent) {
                                        break; // Non-social band breaks the group
                                    }
                                }
                            @endphp

                            @if($socialStyle === 'circles')
                                {{-- CIRCLES: icônes rondes en ligne --}}
                                <div class="flex flex-wrap justify-center gap-3 py-2">
                                    @foreach($consecutiveSocials as $sBand)
                                        <a href="{{ $sBand->data['url'] }}" target="_blank" rel="noopener"
                                           data-band-id="{{ $sBand->id }}" data-band-url="{{ $sBand->data['url'] }}"
                                           class="w-11 h-11 rounded-full flex items-center justify-center transition-all duration-200 trackable-link hover:scale-110 shadow-sm"
                                           style="background: {{ $blockBg }}; border: 1px solid {{ $blockBorder }};">
                                            <x-social-icon :platform="$sBand->data['platform'] ?? ''" size="w-5 h-5" />
                                        </a>
                                    @endforeach
                                </div>

                            @elseif($socialStyle === 'pills')
                                {{-- PILLS: badges compacts en ligne --}}
                                <div class="flex flex-wrap justify-center gap-2 py-1">
                                    @foreach($consecutiveSocials as $sBand)
                                        <a href="{{ $sBand->data['url'] }}" target="_blank" rel="noopener"
                                           data-band-id="{{ $sBand->id }}" data-band-url="{{ $sBand->data['url'] }}"
                                           class="inline-flex items-center gap-2 px-4 py-2.5 {{ $btnRadius }} transition-all duration-200 trackable-link hover:shadow-md"
                                           style="background: {{ $blockBg }}; border: 1px solid {{ $blockBorder }};"
                                           onmouseover="this.style.borderColor='{{ $primaryColor }}50'"
                                           onmouseout="this.style.borderColor='{{ $blockBorder }}'">
                                            <x-social-icon :platform="$sBand->data['platform'] ?? ''" size="w-4 h-4" />
                                            <span class="font-medium text-xs" style="color: #2C2A27;">{{ ucfirst($sBand->data['platform'] ?? '') }}</span>
                                        </a>
                                    @endforeach
                                </div>

                            @else
                                {{-- LIST: détaillé, un par ligne (défaut) --}}
                                @foreach($consecutiveSocials as $sBand)
                                    <a href="{{ $sBand->data['url'] }}" target="_blank" rel="noopener"
                                       data-band-id="{{ $sBand->id }}" data-band-url="{{ $sBand->data['url'] }}"
                                       class="block p-3.5 {{ $btnRadius }} transition-all duration-200 trackable-link"
                                       style="background: {{ $blockBg }}; border: 1px solid {{ $blockBorder }};"
                                       onmouseover="this.style.background='{{ $isBoldTemplate ? '#DBD9D6' : '#F3F4F6' }}'; this.style.borderColor='{{ $isBoldTemplate ? $primaryColor . '60' : '#D1D5DB' }}'"
                                       onmouseout="this.style.background='{{ $blockBg }}'; this.style.borderColor='{{ $blockBorder }}'">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 flex items-center justify-center">
                                                <x-social-icon :platform="$sBand->data['platform'] ?? ''" size="w-6 h-6" />
                                            </div>
                                            <span class="font-medium text-sm" style="color: {{ $isBoldTemplate ? '#4B5563' : '#2C2A27' }};">{{ ucfirst($sBand->data['platform'] ?? '') }}</span>
                                            <svg class="w-4 h-4 ml-auto" fill="#9CA3AF" viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        @endif

                    @elseif($band->type === 'image')
                        <!-- Image(s) -->
                        @php
                            $images = $band->data['images'] ?? [];
                            if (empty($images) && isset($band->data['path'])) {
                                $images = [['path' => $band->data['path'], 'link' => $band->data['link'] ?? '']];
                            }
                        @endphp
                        
                        @if(count($images) === 1)
                            <div class="{{ $btnRadius }} overflow-hidden" style="border: 1px solid {{ $blockBorder }};">
                                @if(!empty($images[0]['link']))
                                    <a href="{{ $images[0]['link'] }}" target="_blank" rel="noopener"
                                       data-band-id="{{ $band->id }}" data-band-url="{{ $images[0]['link'] }}"
                                       class="trackable-link">
                                        <img src="{{ Storage::url($images[0]['path']) }}"
                                             class="w-full h-auto object-contain hover:opacity-90 transition"
                                             style="max-height: 300px;">
                                    </a>
                                @else
                                    <img src="{{ Storage::url($images[0]['path']) }}"
                                         class="w-full h-auto object-contain"
                                         style="max-height: 300px;">
                                @endif
                            </div>
                        @elseif(count($images) >= 2)
                            <div class="grid grid-cols-2 gap-2">
                                @foreach(array_slice($images, 0, 2) as $img)
                                    <div class="{{ $btnRadius }} overflow-hidden" style="border: 1px solid {{ $blockBorder }};">
                                        @if(!empty($img['link']))
                                            <a href="{{ $img['link'] }}" target="_blank" rel="noopener"
                                               data-band-id="{{ $band->id }}" data-band-url="{{ $img['link'] }}"
                                               class="trackable-link">
                                                <img src="{{ Storage::url($img['path']) }}"
                                                     class="w-full h-auto object-contain hover:opacity-90 transition"
                                                     style="max-height: 200px;">
                                            </a>
                                        @else
                                            <img src="{{ Storage::url($img['path']) }}"
                                                 class="w-full h-auto object-contain"
                                                 style="max-height: 200px;">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    @elseif($band->type === 'text_block')
                        <!-- Bloc de texte -->
                        <div class="p-4 {{ $btnRadius }}" style="background: {{ $blockBg }}; border: 1px solid {{ $blockBorder }};">
                            <p class="whitespace-pre-line text-sm leading-relaxed" style="color: #4B5563;">{{ $band->data['text'] }}</p>
                        </div>

                    @elseif($band->type === 'video_embed')
                        <!-- Vidéo intégrée (YouTube/TikTok) -->
                        @php
                            $videoUrl = $band->data['url'] ?? '';
                            $videoId = $band->data['video_id'] ?? '';
                            $platform = $band->data['platform'] ?? '';
                            
                            // Auto-detect platform + extract ID si pas encore fait
                            if (empty($platform) && $videoUrl) {
                                if (str_contains($videoUrl, 'youtube.com') || str_contains($videoUrl, 'youtu.be')) {
                                    $platform = 'youtube';
                                    if (preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $videoUrl, $m)) {
                                        $videoId = $m[1];
                                    }
                                } elseif (str_contains($videoUrl, 'tiktok.com')) {
                                    $platform = 'tiktok';
                                    if (preg_match('/video\/(\d+)/', $videoUrl, $m)) {
                                        $videoId = $m[1];
                                    }
                                } elseif (str_contains($videoUrl, 'vimeo.com')) {
                                    $platform = 'vimeo';
                                    if (preg_match('/vimeo\.com\/(\d+)/', $videoUrl, $m)) {
                                        $videoId = $m[1];
                                    }
                                }
                            }
                        @endphp
                        
                        @if($platform === 'youtube' && $videoId)
                            <div class="{{ $btnRadius }} overflow-hidden" style="border: 1px solid {{ $blockBorder }};">
                                <div style="position: relative; padding-bottom: 56.25%; height: 0;">
                                    <iframe src="https://www.youtube.com/embed/{{ $videoId }}?rel=0" 
                                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                                            frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            </div>
                        @elseif($platform === 'tiktok' && $videoId)
                            <div class="{{ $btnRadius }} overflow-hidden" style="border: 1px solid {{ $blockBorder }};">
                                <blockquote class="tiktok-embed" cite="{{ $videoUrl }}" data-video-id="{{ $videoId }}" style="max-width: 100%;">
                                    <section><a target="_blank" href="{{ $videoUrl }}">Voir sur TikTok</a></section>
                                </blockquote>
                            </div>
                        @elseif($platform === 'vimeo' && $videoId)
                            <div class="{{ $btnRadius }} overflow-hidden" style="border: 1px solid {{ $blockBorder }};">
                                <div style="position: relative; padding-bottom: 56.25%; height: 0;">
                                    <iframe src="https://player.vimeo.com/video/{{ $videoId }}" 
                                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                                            frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            </div>
                        @elseif($videoUrl)
                            {{-- Fallback: lien cliquable --}}
                            <a href="{{ $videoUrl }}" target="_blank" rel="noopener"
                               class="flex items-center gap-3 p-3.5 {{ $btnRadius }} transition-all duration-200"
                               style="background: {{ $blockBg }}; border: 1px solid {{ $blockBorder }};">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: #FEE2E2;">
                                    <svg class="w-5 h-5" fill="#EF4444" viewBox="0 0 24 24"><polygon points="9,6 19,12 9,18" /></svg>
                                </div>
                                <span class="font-medium text-sm" style="color: #2C2A27;">Voir la vidéo</span>
                                <svg class="w-4 h-4 ml-auto" fill="#9CA3AF" viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
                            </a>
                        @endif

                    @elseif($band->type === 'image_carousel')
                        <!-- Carrousel d'images -->
                        @php
                            $carouselImages = $band->data['images'] ?? [];
                            $autoplay = $band->data['autoplay'] ?? true;
                            $carouselId = 'carousel-' . $band->id;
                        @endphp
                        
                        @if(count($carouselImages) > 0)
                            <div class="{{ $btnRadius }} overflow-hidden relative" style="border: 1px solid {{ $blockBorder }};" id="{{ $carouselId }}" data-autoplay="{{ $autoplay ? '1' : '0' }}">
                                {{-- Images container --}}
                                <div class="carousel-track flex transition-transform duration-500 ease-out" style="touch-action: pan-y;">
                                    @foreach($carouselImages as $idx => $img)
                                        <div class="carousel-slide flex-shrink-0 w-full">
                                            @if(!empty($img['link']))
                                                <a href="{{ $img['link'] }}" target="_blank" rel="noopener">
                                                    <img src="{{ Storage::url($img['path']) }}" 
                                                         class="w-full h-auto object-contain" style="max-height: 300px;"
                                                         alt="{{ $img['caption'] ?? '' }}">
                                                </a>
                                            @else
                                                <img src="{{ Storage::url($img['path']) }}" 
                                                     class="w-full h-auto object-contain" style="max-height: 300px;"
                                                     alt="{{ $img['caption'] ?? '' }}">
                                            @endif
                                            @if(!empty($img['caption']))
                                                <p class="text-xs text-center py-2 px-3" style="color: #9CA3AF;">{{ $img['caption'] }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                
                                {{-- Navigation arrows --}}
                                @if(count($carouselImages) > 1)
                                    <button onclick="carouselPrev('{{ $carouselId }}')" class="absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full flex items-center justify-center transition-opacity" style="background: rgba(255,255,255,0.85); box-shadow: 0 1px 4px rgba(0,0,0,0.15);">
                                        <svg class="w-4 h-4" fill="#2C2A27" viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
                                    </button>
                                    <button onclick="carouselNext('{{ $carouselId }}')" class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full flex items-center justify-center transition-opacity" style="background: rgba(255,255,255,0.85); box-shadow: 0 1px 4px rgba(0,0,0,0.15);">
                                        <svg class="w-4 h-4" fill="#2C2A27" viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
                                    </button>
                                    
                                    {{-- Dots --}}
                                    <div class="flex justify-center gap-1.5 py-2">
                                        @foreach($carouselImages as $idx => $img)
                                            <button onclick="carouselGoTo('{{ $carouselId }}', {{ $idx }})" 
                                                    class="carousel-dot w-2 h-2 rounded-full transition-all duration-200"
                                                    style="background: {{ $idx === 0 ? '#2C2A27' : '#D1D5DB' }};"></button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif

                    @elseif($band->type === 'cta_button')
                        <!-- Bouton personnalisé -->
                        @php
                            $btnBg = $band->data['bg_color'] ?? $profile->button_color ?? $secondaryColor;
                            $bHex = ltrim($btnBg, '#');
                            if (strlen($bHex) === 6) {
                                $bR = hexdec(substr($bHex, 0, 2)); $bG = hexdec(substr($bHex, 2, 2)); $bB = hexdec(substr($bHex, 4, 2));
                                $btnTextColor = ((0.299 * $bR + 0.587 * $bG + 0.114 * $bB) / 255 > 0.6) ? '#2C2A27' : '#FFFFFF';
                            } else { $btnTextColor = '#FFFFFF'; }
                        @endphp
                        <a href="{{ $band->data['url'] ?? '#' }}" target="_blank" rel="noopener"
                           data-band-id="{{ $band->id }}" data-band-url="{{ $band->data['url'] ?? '' }}"
                           class="flex items-center justify-center space-x-2 w-full {{ $buttonStyle === 'square_wide' ? 'py-4 px-5' : 'py-3.5 px-5' }} text-center {{ $btnRadius }} font-semibold {{ $buttonStyle === 'square_wide' ? 'text-base tracking-wide' : 'text-sm' }} shadow-md transition-all duration-200 trackable-link"
                           style="background: {{ $btnBg }}; color: {{ $btnTextColor }};"
                           onmouseover="this.style.opacity='0.9'; this.style.transform='translateY(-1px)'"
                           onmouseout="this.style.opacity='1'; this.style.transform='translateY(0)'">
                            @if(!empty($band->data['icon']))
                                <span>{{ $band->data['icon'] }}</span>
                            @endif
                            <span>{{ $band->data['label'] ?? 'Lien' }}</span>
                        </a>

                    @endif

                @endforeach

                @if($profile->contentBands->isEmpty())
                    <div class="py-12 text-center">
                        <p class="text-sm" style="color: #9CA3AF;">Ce profil n'a pas encore de contenu</p>
                    </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="px-5 pb-8 pt-4 text-center" style="border-top: 1px solid #E5E7EB;">
                <a href="https://linkcard.ca" target="_blank" class="inline-flex items-center space-x-1 group">
                    <span class="text-xs" style="color: #9CA3AF;">Propulsé par</span>
                    <span class="text-xs font-semibold transition-colors" style="color: #6B7280;" 
                          onmouseover="this.style.color='#42B574'" 
                          onmouseout="this.style.color='#6B7280'">Link-Card</span>
                </a>
                <p class="text-xs mt-2" style="color: #D1D5DB;">
                    {{ number_format($profile->view_count) }} vue{{ $profile->view_count > 1 ? 's' : '' }}
                </p>
                <div class="flex items-center justify-center gap-3 mt-3">
                    <a href="{{ route('legal.terms') }}" class="text-xs" style="color: #D1D5DB;">Conditions</a>
                    <span class="text-xs" style="color: #E5E7EB;">·</span>
                    <a href="{{ route('legal.privacy') }}" class="text-xs" style="color: #D1D5DB;">Confidentialité</a>
                    <span class="text-xs" style="color: #E5E7EB;">·</span>
                    <a href="{{ route('legal.refund') }}" class="text-xs" style="color: #D1D5DB;">Remboursement</a>
                </div>
            </div>
        </div>
    </div>

    <!-- SHARE POPUP OVERLAY -->
    <div class="share-overlay" id="shareOverlay" onclick="if(event.target === this) closeSharePopup()">
        <div class="share-popup">
            <div class="text-center mb-5">
                <h3 class="text-lg font-semibold" style="color: #2C2A27;">Partager ce profil</h3>
                <p class="text-sm mt-1" style="color: #9CA3AF;">Choisissez comment partager</p>
            </div>
            
            <!-- URL Preview -->
            <div class="flex items-center gap-3 p-3 rounded-xl mb-4" style="background: #F3F4F6;">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #42B574, #2D7A4F);">
                    <svg class="w-4 h-4" fill="white" viewBox="0 0 24 24"><path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/></svg>
                </div>
                <span class="text-sm truncate flex-1" style="color: #4B5563;" id="shareUrl">{{ $profileUrl }}</span>
            </div>
            
            <!-- Actions -->
            <div class="space-y-2">
                <!-- Copier le lien -->
                <button onclick="copyLink()" class="w-full flex items-center gap-3 p-3.5 rounded-xl transition-all duration-200" style="border: 1px solid #E5E7EB; background: white;" onmouseover="this.style.background='#F9FAFB'; this.style.borderColor='#D1D5DB'" onmouseout="this.style.background='white'; this.style.borderColor='#E5E7EB'">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: #F0F9F4;">
                        <svg class="w-5 h-5" fill="#42B574" viewBox="0 0 24 24"><path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/></svg>
                    </div>
                    <div class="text-left flex-1">
                        <p class="font-semibold text-sm" style="color: #2C2A27;">Copier le lien</p>
                        <p class="text-xs" style="color: #9CA3AF;">Coller n'importe où</p>
                    </div>
                </button>
                
                <!-- Partager (Web Share API) -->
                <button onclick="nativeShare()" id="nativeShareBtn" class="w-full flex items-center gap-3 p-3.5 rounded-xl transition-all duration-200" style="border: 1px solid #E5E7EB; background: white; display: none;" onmouseover="this.style.background='#F9FAFB'; this.style.borderColor='#D1D5DB'" onmouseout="this.style.background='white'; this.style.borderColor='#E5E7EB'">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: #EFF6FF;">
                        <svg class="w-5 h-5" fill="#3B82F6" viewBox="0 0 24 24"><path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92s2.92-1.31 2.92-2.92-1.31-2.92-2.92-2.92z"/></svg>
                    </div>
                    <div class="text-left flex-1">
                        <p class="font-semibold text-sm" style="color: #2C2A27;">Partager</p>
                        <p class="text-xs" style="color: #9CA3AF;">Via une autre app</p>
                    </div>
                </button>
                
                <!-- QR Code (PRO/PREMIUM) -->
                @if($canShowQR)
                    <button onclick="showQRCode()" class="w-full flex items-center gap-3 p-3.5 rounded-xl transition-all duration-200" style="border: 1px solid #E5E7EB; background: white;" onmouseover="this.style.background='#F9FAFB'; this.style.borderColor='#D1D5DB'" onmouseout="this.style.background='white'; this.style.borderColor='#E5E7EB'">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: #F3F4F6;">
                            <svg class="w-5 h-5" fill="#2C2A27" viewBox="0 0 24 24"><path d="M3 11h8V3H3v8zm2-6h4v4H5V5zm8-2v8h8V3h-8zm6 6h-4V5h4v4zM3 21h8v-8H3v8zm2-6h4v4H5v-4zm13-2h-2v4h2v-4zm2 0h2v6h-6v-2h4v-4zm-2 6h-4v2h4v-2zm-4-4h-2v2h2v-2z"/></svg>
                        </div>
                        <div class="text-left flex-1">
                            <p class="font-semibold text-sm" style="color: #2C2A27;">QR Code</p>
                            <p class="text-xs" style="color: #9CA3AF;">Télécharger l'image</p>
                        </div>
                    </button>
                @else
                    <button disabled class="w-full flex items-center gap-3 p-3.5 rounded-xl opacity-60 cursor-not-allowed" style="border: 1px solid #E5E7EB; background: #F9FAFB;">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: #F3F4F6;">
                            <svg class="w-5 h-5" fill="#9CA3AF" viewBox="0 0 24 24"><path d="M3 11h8V3H3v8zm2-6h4v4H5V5zm8-2v8h8V3h-8zm6 6h-4V5h4v4zM3 21h8v-8H3v8zm2-6h4v4H5v-4zm13-2h-2v4h2v-4zm2 0h2v6h-6v-2h4v-4zm-2 6h-4v2h4v-2zm-4-4h-2v2h2v-2z"/></svg>
                        </div>
                        <div class="text-left flex-1">
                            <p class="font-semibold text-sm" style="color: #9CA3AF;">QR Code</p>
                            <p class="text-xs" style="color: #D1D5DB;">Télécharger l'image</p>
                        </div>
                        <span class="text-xs font-semibold px-2 py-1 rounded-md" style="background: linear-gradient(135deg, #F59E0B, #D97706); color: white;">PRO</span>
                    </button>
                @endif
            </div>
            
            <!-- Fermer -->
            <button onclick="closeSharePopup()" class="w-full mt-4 py-2.5 text-sm font-medium rounded-lg transition-colors" style="color: #9CA3AF;" onmouseover="this.style.color='#4B5563'; this.style.background='#F3F4F6'" onmouseout="this.style.color='#9CA3AF'; this.style.background='transparent'">
                Fermer
            </button>
        </div>
    </div>

    <!-- QR CODE POPUP -->
    @if($canShowQR)
    <div class="share-overlay" id="qrOverlay" onclick="if(event.target === this) closeQRPopup()">
        <div class="share-popup" style="text-align: center;">
            <h3 class="text-lg font-semibold mb-4" style="color: #2C2A27;">QR Code du profil</h3>
            <div class="mx-auto mb-4 p-4 bg-white rounded-xl inline-block" style="border: 1px solid #E5E7EB;">
                <img src="{{ route('profile.qr.download', $profile) }}?inline=1" alt="QR Code" class="w-44 h-44">
            </div>
            <p class="text-xs mb-4" style="color: #9CA3AF;">{{ $profileUrl }}</p>
            <a href="{{ route('profile.qr.download', $profile) }}" download class="inline-flex items-center justify-center gap-2 px-6 py-3 text-white text-sm font-semibold rounded-xl transition-all duration-200" style="background: #42B574;" onmouseover="this.style.background='#3DA367'" onmouseout="this.style.background='#42B574'">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
                Télécharger PNG
            </a>
            <button onclick="closeQRPopup()" class="block w-full mt-4 py-2.5 text-sm font-medium rounded-lg transition-colors" style="color: #9CA3AF;" onmouseover="this.style.color='#4B5563'; this.style.background='#F3F4F6'" onmouseout="this.style.color='#9CA3AF'; this.style.background='transparent'">
                Fermer
            </button>
        </div>
    </div>
    @endif

    <!-- CONTACT POPUP -->
    <div class="share-overlay" id="contactOverlay" onclick="if(event.target === this) closeContactPopup()">
        <div class="share-popup">
            <div class="text-center mb-5">
                <h3 class="text-lg font-semibold" style="color: #2C2A27;">Ajouter aux contacts</h3>
                <p class="text-sm mt-1" style="color: #9CA3AF;">Choisissez comment ajouter {{ $profile->full_name }}</p>
            </div>
            
            <div class="space-y-2">
                <!-- Option 1: Télécharger la vCard -->
                @php $contactBand = $profile->contentBands->firstWhere('type', 'contact_button'); @endphp
                <a href="{{ route('profile.vcard', $profile) }}"
                   onclick="if({{ $contactBand ? $contactBand->id : 0 }}) { fetch('/api/track-click', { method: 'POST', headers: {'Content-Type': 'application/json', 'Accept': 'application/json'}, body: JSON.stringify({ band_id: {{ $contactBand ? $contactBand->id : 0 }}, url: 'vcard_download' }), keepalive: true }).catch(() => {}); }"
                   class="w-full flex items-center gap-3 p-3.5 rounded-xl transition-all duration-200" style="border: 1px solid #E5E7EB; background: white;" onmouseover="this.style.background='#F9FAFB'; this.style.borderColor='#D1D5DB'" onmouseout="this.style.background='white'; this.style.borderColor='#E5E7EB'">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: #F3F4F6;">
                        <svg class="w-5 h-5" fill="#2C2A27" viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
                    </div>
                    <div class="text-left flex-1">
                        <p class="font-semibold text-sm" style="color: #2C2A27;">Télécharger le contact</p>
                        <p class="text-xs" style="color: #9CA3AF;">Enregistrer dans votre téléphone</p>
                    </div>
                </a>
                
                <!-- Option 2: Ajouter sur Link-Card -->
                @if($isOwnProfile)
                    {{-- C'est son propre profil --}}
                    <div class="w-full flex items-center gap-3 p-3.5 rounded-xl opacity-50" style="border: 1px solid #E5E7EB; background: #F9FAFB;">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: #F0F9F4;">
                            <svg class="w-5 h-5" fill="#42B574" viewBox="0 0 24 24"><path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/></svg>
                        </div>
                        <div class="text-left flex-1">
                            <p class="font-semibold text-sm" style="color: #9CA3AF;">C'est votre profil</p>
                        </div>
                    </div>
                @elseif($connectionStatus === 'accepted')
                    {{-- Déjà connectés --}}
                    <div class="w-full flex items-center gap-3 p-3.5 rounded-xl" style="border: 1px solid #42B574; background: #F0F9F4;">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: white;">
                            <svg class="w-5 h-5" fill="#42B574" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                        </div>
                        <div class="text-left flex-1">
                            <p class="font-semibold text-sm" style="color: #42B574;">Connecté sur Link-Card</p>
                            <p class="text-xs" style="color: #4B5563;">Vous êtes déjà connectés</p>
                        </div>
                    </div>
                @elseif($connectionStatus === 'pending_sent')
                    {{-- Demande envoyée --}}
                    <div class="w-full flex items-center gap-3 p-3.5 rounded-xl" style="border: 1px solid #F59E0B; background: #FEF3C7;">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: white;">
                            <svg class="w-5 h-5" fill="#F59E0B" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                        </div>
                        <div class="text-left flex-1">
                            <p class="font-semibold text-sm" style="color: #92400E;">Demande envoyée</p>
                            <p class="text-xs" style="color: #92400E;">En attente d'acceptation</p>
                        </div>
                    </div>
                @elseif($connectionStatus === 'pending_received')
                    {{-- Demande reçue → accepter directement --}}
                    <form method="POST" action="{{ route('connections.accept.public', $profile->user_id) }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 p-3.5 rounded-xl transition-all duration-200" style="border: 1px solid #42B574; background: #F0F9F4;" onmouseover="this.style.background='#E0F5E9'" onmouseout="this.style.background='#F0F9F4'">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: #42B574;">
                                <svg class="w-5 h-5" fill="white" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                            </div>
                            <div class="text-left flex-1">
                                <p class="font-semibold text-sm" style="color: #2C2A27;">Accepter la demande</p>
                                <p class="text-xs" style="color: #4B5563;">{{ $profile->full_name }} veut se connecter</p>
                            </div>
                        </button>
                    </form>
                @elseif(auth()->check())
                    {{-- Connecté, pas encore de demande → envoyer --}}
                    <form method="POST" action="{{ route('connections.send', $profile->user_id) }}" id="connectionForm">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 p-3.5 rounded-xl transition-all duration-200" style="border: 1px solid #E5E7EB; background: white;" onmouseover="this.style.background='#F0F9F4'; this.style.borderColor='#42B574'" onmouseout="this.style.background='white'; this.style.borderColor='#E5E7EB'">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: #F0F9F4;">
                                <svg class="w-5 h-5" fill="#42B574" viewBox="0 0 24 24"><path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/></svg>
                            </div>
                            <div class="text-left flex-1">
                                <p class="font-semibold text-sm" style="color: #2C2A27;">Ajouter sur Link-Card</p>
                                <p class="text-xs" style="color: #9CA3AF;">Se connecter mutuellement</p>
                            </div>
                        </button>
                    </form>
                @else
                    {{-- Pas connecté → redirect login --}}
                    <a href="{{ route('login', ['ref' => $profile->username, 'action' => 'connect']) }}" class="w-full flex items-center gap-3 p-3.5 rounded-xl transition-all duration-200" style="border: 1px solid #E5E7EB; background: white;" onmouseover="this.style.background='#F0F9F4'; this.style.borderColor='#42B574'" onmouseout="this.style.background='white'; this.style.borderColor='#E5E7EB'">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: #F0F9F4;">
                            <svg class="w-5 h-5" fill="#42B574" viewBox="0 0 24 24"><path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/></svg>
                        </div>
                        <div class="text-left flex-1">
                            <p class="font-semibold text-sm" style="color: #2C2A27;">Ajouter sur Link-Card</p>
                            <p class="text-xs" style="color: #9CA3AF;">Connexion ou inscription requise</p>
                        </div>
                    </a>
                @endif
            </div>
            
            <!-- Fermer -->
            <button onclick="closeContactPopup()" class="w-full mt-4 py-2.5 text-sm font-medium rounded-lg transition-colors" style="color: #9CA3AF;" onmouseover="this.style.color='#4B5563'; this.style.background='#F3F4F6'" onmouseout="this.style.color='#9CA3AF'; this.style.background='transparent'">
                Fermer
            </button>
        </div>
    </div>

    <!-- TOAST -->
    <div class="toast" id="toast">
        <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
        <span id="toastMessage">Lien copié !</span>
    </div>

    <script>
        const profileUrl = "{{ $profileUrl }}";
        const profileName = "{{ $profile->full_name }}";
        
        // Afficher le bouton partage natif si supporté
        if (navigator.share) {
            document.getElementById('nativeShareBtn').style.display = 'flex';
        }
        
        function openSharePopup() {
            document.getElementById('shareOverlay').classList.add('active');
        }
        
        function closeSharePopup() {
            document.getElementById('shareOverlay').classList.remove('active');
        }
        
        function copyLink() {
            navigator.clipboard.writeText(profileUrl).then(() => {
                showToast('Lien copié !');
                closeSharePopup();
            }).catch(() => {
                // Fallback pour les vieux navigateurs
                const input = document.createElement('input');
                input.value = profileUrl;
                document.body.appendChild(input);
                input.select();
                document.execCommand('copy');
                document.body.removeChild(input);
                showToast('Lien copié !');
                closeSharePopup();
            });
        }
        
        function nativeShare() {
            if (navigator.share) {
                navigator.share({
                    title: profileName + ' - Link-Card',
                    text: 'Découvrez le profil de ' + profileName,
                    url: profileUrl
                }).then(() => {
                    closeSharePopup();
                }).catch(() => {});
            }
        }
        
        @if($canShowQR)
        function showQRCode() {
            closeSharePopup();
            document.getElementById('qrOverlay').classList.add('active');
        }
        
        function closeQRPopup() {
            document.getElementById('qrOverlay').classList.remove('active');
        }
        @endif
        
        function showToast(message) {
            const toast = document.getElementById('toast');
            document.getElementById('toastMessage').textContent = message;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 2500);
        }
        
        // Contact popup
        function openContactPopup() {
            document.getElementById('contactOverlay').classList.add('active');
        }
        function closeContactPopup() {
            document.getElementById('contactOverlay').classList.remove('active');
        }
        
        // Handle connection form submit via AJAX
        const connectionForm = document.getElementById('connectionForm');
        if (connectionForm) {
            connectionForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const btn = this.querySelector('button');
                btn.disabled = true;
                btn.style.opacity = '0.6';
                
                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                }).then(r => r.json()).then(data => {
                    closeContactPopup();
                    showToast(data.message || 'Demande envoyée !');
                    // Update button to show pending
                    btn.closest('form').outerHTML = `
                        <div class="w-full flex items-center gap-3 p-3.5 rounded-xl" style="border: 1px solid #F59E0B; background: #FEF3C7;">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: white;">
                                <svg class="w-5 h-5" fill="#F59E0B" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                            </div>
                            <div class="text-left flex-1">
                                <p class="font-semibold text-sm" style="color: #92400E;">Demande envoyée</p>
                                <p class="text-xs" style="color: #92400E;">En attente d'acceptation</p>
                            </div>
                        </div>`;
                }).catch(() => {
                    btn.disabled = false;
                    btn.style.opacity = '1';
                    showToast('Erreur, réessayez.');
                });
            });
        }
    </script>

    <!-- Click tracking -->
    <script>
        document.querySelectorAll('.trackable-link').forEach(link => {
            link.addEventListener('click', function() {
                const bandId = this.dataset.bandId;
                const url = this.dataset.bandUrl;
                if (bandId) {
                    fetch('/api/track-click', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
                        body: JSON.stringify({ band_id: bandId, url: url || '' }),
                        keepalive: true
                    }).catch(() => {});
                }
            });
        });
    </script>

    <!-- Carousel engine -->
    <script>
        const carousels = {};

        function initCarousel(id) {
            const el = document.getElementById(id);
            if (!el || carousels[id]) return;
            
            const track = el.querySelector('.carousel-track');
            const slides = el.querySelectorAll('.carousel-slide');
            const dots = el.querySelectorAll('.carousel-dot');
            const total = slides.length;
            if (total <= 1) return;

            carousels[id] = { current: 0, total, track, dots, el, interval: null };

            // Touch/swipe support
            let startX = 0, startY = 0, isDragging = false;
            
            track.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
                startY = e.touches[0].clientY;
                isDragging = true;
                clearAutoplay(id);
            }, { passive: true });
            
            track.addEventListener('touchend', (e) => {
                if (!isDragging) return;
                const diffX = e.changedTouches[0].clientX - startX;
                const diffY = Math.abs(e.changedTouches[0].clientY - startY);
                // Only swipe if horizontal movement > vertical (avoid blocking scroll)
                if (Math.abs(diffX) > 40 && Math.abs(diffX) > diffY) {
                    if (diffX < 0) carouselNext(id);
                    else carouselPrev(id);
                }
                isDragging = false;
                startAutoplay(id);
            }, { passive: true });

            // Autoplay
            if (el.dataset.autoplay === '1') {
                startAutoplay(id);
            }
        }

        function carouselGoTo(id, index) {
            const c = carousels[id];
            if (!c) return;
            c.current = ((index % c.total) + c.total) % c.total;
            c.track.style.transform = `translateX(-${c.current * 100}%)`;
            c.dots.forEach((d, i) => {
                d.style.background = i === c.current ? '#2C2A27' : '#D1D5DB';
            });
        }

        function carouselNext(id) {
            const c = carousels[id];
            if (c) carouselGoTo(id, c.current + 1);
        }

        function carouselPrev(id) {
            const c = carousels[id];
            if (c) carouselGoTo(id, c.current - 1);
        }

        function startAutoplay(id) {
            const c = carousels[id];
            if (!c) return;
            clearAutoplay(id);
            c.interval = setInterval(() => carouselNext(id), 4000);
        }

        function clearAutoplay(id) {
            const c = carousels[id];
            if (c && c.interval) {
                clearInterval(c.interval);
                c.interval = null;
            }
        }

        // Init all carousels on page
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[id^="carousel-"]').forEach(el => {
                initCarousel(el.id);
            });
        });
    </script>

    {{-- TikTok embed script (only if needed) --}}
    @if($profile->contentBands->where('type', 'video_embed')->contains(fn($b) => ($b->data['platform'] ?? '') === 'tiktok'))
        <script async src="https://www.tiktok.com/embed.js"></script>
    @endif

    @livewireScripts
</body>
</html>
