<div class="sticky top-6">
    <p class="text-xs text-center mb-3 font-medium uppercase tracking-wider"
       style="font-family: 'Manrope', sans-serif; color: #9CA3AF; letter-spacing: 0.08em;">
        Aperçu en direct
    </p>
    <div class="rounded-2xl overflow-hidden" style="box-shadow: 0 8px 32px rgba(0,0,0,0.12); border: 1px solid #E5E7EB;">
        <div class="overflow-y-auto" style="max-height: calc(100vh - 120px); background: white;">

            @php
                $templateSlug = $profile->template_id ?? 'classic';
                $templateConfig = $profile->getEffectiveTemplateConfig();
                $headerStyle = $templateConfig['header_style'] ?? 'classic';
                $transition = $templateConfig['transition'] ?? 'wave';
                $photoStyle = $templateConfig['photo_style'] ?? 'round_center';
            @endphp

            {{-- HEADER based on template --}}
            @if($headerStyle === 'bold')
                <div style="background: #2C2A27; position: relative;">
                    @if($transition === 'none')
                        <div class="absolute bottom-0 left-0 right-0" style="height: 4px; background: linear-gradient(90deg, {{ $primary_color }}, {{ $secondary_color }}); z-index: 2;"></div>
                    @endif
                    <div class="px-6 pt-10 pb-6 text-center" style="color: #FFFFFF;">
                        @include('livewire.profile.partials.preview-photo', ['photoStyle' => $photoStyle, 'borderStyle' => "border: 3px solid {$primary_color};"])
                        @include('livewire.profile.partials.preview-info', ['textColor' => '#FFFFFF'])
                    </div>
                    @include('livewire.profile.partials.preview-transition', ['transition' => $transition, 'fillColor' => '#E8E6E3'])
                </div>
            @elseif($headerStyle === 'minimal')
                <div style="height: 7px; background: linear-gradient(90deg, {{ $primary_color }}, {{ $secondary_color }});"></div>
                <div style="background: linear-gradient(180deg, {{ $primary_color }}30 0%, {{ $primary_color }}12 50%, {{ $primary_color }}08 100%);">
                    <div class="px-6 pt-8 pb-6 text-center">
                        @include('livewire.profile.partials.preview-photo', ['photoStyle' => $photoStyle, 'shadowColor' => $primary_color])
                        @include('livewire.profile.partials.preview-info', ['textColor' => '#2C2A27'])
                    </div>
                    @include('livewire.profile.partials.preview-transition', ['transition' => $transition])
                </div>
            @elseif($headerStyle === 'banner')
                <div style="background: linear-gradient(135deg, {{ $primary_color }}, {{ $secondary_color }});">
                    <div style="height: 100px;"></div>
                    @include('livewire.profile.partials.preview-transition', ['transition' => $transition])
                </div>
                <div class="bg-white text-center pb-4">
                    @include('livewire.profile.partials.preview-photo', ['photoStyle' => $photoStyle, 'overlapContext' => true])
                    <div class="mt-3 px-6">
                        @include('livewire.profile.partials.preview-info', ['textColor' => '#2C2A27'])
                    </div>
                </div>
            @elseif($headerStyle === 'split')
                <div style="background: linear-gradient(135deg, {{ $primary_color }} 0%, {{ $secondary_color }} 100%);">
                    <div class="relative overflow-hidden">
                        <div class="flex relative" style="z-index: 1;">
                            <div class="w-[38%] flex items-center justify-center py-10" style="background: rgba(0,0,0,0.12);">
                                @if($profile->photo_path)
                                    <img src="{{ Storage::url($profile->photo_path) }}" class="w-20 h-20 rounded-full object-cover border-3 border-white shadow-xl">
                                @else
                                    <div class="w-20 h-20 rounded-full bg-white/20 border-3 border-white/80 shadow-xl flex items-center justify-center">
                                        <span class="text-3xl">👤</span>
                                    </div>
                                @endif
                            </div>
                            <div class="w-[62%] flex flex-col justify-center py-10 px-4" style="background: rgba(255,255,255,0.06); color: {{ $headerTextColor }};">
                                <h2 class="text-lg font-semibold" style="font-family: 'Manrope', sans-serif;">{{ $full_name ?: 'Votre nom' }}</h2>
                                @if($job_title)<p class="text-xs font-medium mt-1" style="opacity: 0.9;">{{ $job_title }}</p>@endif
                                @if($company || $location)<p class="text-xs mt-0.5" style="opacity: 0.8;">{{ $company }}@if($company && $location) · @endif{{ $location }}</p>@endif
                            </div>
                        </div>
                    </div>
                    @include('livewire.profile.partials.preview-transition', ['transition' => $transition])
                </div>
            @elseif($headerStyle === 'geometric')
                <div style="background: linear-gradient(135deg, {{ $primary_color }}, {{ $secondary_color }});">
                    <div class="relative overflow-hidden">
                        <div class="absolute" style="top: 10px; left: -20px; width: 80px; height: 80px; border-radius: 50%; background: rgba(255,255,255,0.07);"></div>
                        <div class="absolute" style="top: -15px; right: 20px; width: 100px; height: 100px; border-radius: 50%; background: rgba(255,255,255,0.05);"></div>
                        <div class="relative z-10 px-6 pt-10 pb-2 text-center" style="color: {{ $headerTextColor }};">
                            @include('livewire.profile.partials.preview-photo', ['photoStyle' => $photoStyle])
                            @include('livewire.profile.partials.preview-info', ['textColor' => $headerTextColor])
                        </div>
                    </div>
                    @include('livewire.profile.partials.preview-transition', ['transition' => $transition])
                </div>
            @elseif($headerStyle === 'videaste')
                {{-- Vidéaste: animated gradient + dark cinematic --}}
                <div style="background: linear-gradient(135deg, #1a1a2e 0%, {{ $primary_color }}CC 50%, {{ $secondary_color }} 100%);">
                    <div class="relative overflow-hidden">
                        <div class="absolute" style="width: 6px; height: 6px; border-radius: 50%; background: {{ $primary_color }}; top: 15%; left: 15%; opacity: 0.5;"></div>
                        <div class="absolute" style="width: 4px; height: 4px; border-radius: 50%; background: white; top: 30%; right: 20%; opacity: 0.3;"></div>
                        <div class="absolute" style="width: 8px; height: 8px; border-radius: 50%; background: {{ $primary_color }}60; bottom: 30%; left: 30%; opacity: 0.4;"></div>
                        <div class="absolute inset-0" style="background: radial-gradient(ellipse at center, transparent 50%, rgba(0,0,0,0.3) 100%);"></div>
                        <div class="relative z-10 px-6 pt-10 pb-2 text-center" style="color: #FFFFFF;">
                            @include('livewire.profile.partials.preview-photo', ['photoStyle' => $photoStyle])
                            @include('livewire.profile.partials.preview-info', ['textColor' => '#FFFFFF'])
                        </div>
                    </div>
                    @include('livewire.profile.partials.preview-transition', ['transition' => $transition])
                </div>
            @elseif($headerStyle === 'artiste')
                {{-- Artiste: organic blobs --}}
                <div style="background: linear-gradient(160deg, {{ $primary_color }}, {{ $secondary_color }});">
                    <div class="relative overflow-hidden">
                        <div class="absolute" style="top: -20px; right: -15px; width: 80px; height: 80px; border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; background: rgba(255,255,255,0.06);"></div>
                        <div class="absolute" style="bottom: 10px; left: -20px; width: 60px; height: 60px; border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%; background: rgba(255,255,255,0.04);"></div>
                        <div class="relative z-10 px-6 pt-10 pb-2 text-center" style="color: {{ $headerTextColor }};">
                            @include('livewire.profile.partials.preview-photo', ['photoStyle' => $photoStyle])
                            @include('livewire.profile.partials.preview-info', ['textColor' => $headerTextColor])
                        </div>
                    </div>
                    @include('livewire.profile.partials.preview-transition', ['transition' => $transition])
                </div>
            @elseif($headerStyle === 'entrepreneur')
                {{-- Entrepreneur: business lines + square photo --}}
                @php $previewLogoPath = $profile->template_config['logo_path'] ?? null; @endphp
                <div style="background: linear-gradient(135deg, {{ $primary_color }}, {{ $secondary_color }});">
                    <div class="relative overflow-hidden">
                        <div style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);"></div>
                        <div style="position: absolute; right: 15px; top: 0; bottom: 0; width: 30px; background: rgba(255,255,255,0.04);"></div>
                        @if($previewLogoPath)
                            <div style="position: absolute; top: 12px; left: 10px; z-index: 5;">
                                <img src="{{ Storage::url($previewLogoPath) }}" class="w-8 h-8 rounded-full object-cover" style="border: 2px solid rgba(255,255,255,0.8); box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                            </div>
                        @endif
                        <div class="relative z-10 px-6 pt-10 pb-2 text-center" style="color: {{ $headerTextColor }};">
                            @include('livewire.profile.partials.preview-photo', ['photoStyle' => $photoStyle])
                            @include('livewire.profile.partials.preview-info', ['textColor' => $headerTextColor])
                        </div>
                    </div>
                    @include('livewire.profile.partials.preview-transition', ['transition' => $transition])
                </div>
            @else
                {{-- classic, wave, diagonal, arch --}}
                <div style="background: linear-gradient({{ $headerStyle === 'diagonal' ? '135deg' : '180deg' }}, {{ $primary_color }} 0%, {{ $secondary_color }} 100%);">
                    <div class="px-6 pt-10 pb-2 text-center" style="color: {{ $headerTextColor }};">
                        @include('livewire.profile.partials.preview-photo', ['photoStyle' => $photoStyle])
                        @include('livewire.profile.partials.preview-info', ['textColor' => $headerTextColor])
                    </div>
                    @include('livewire.profile.partials.preview-transition', ['transition' => $transition])
                </div>
            @endif

            <!-- CONTENT BANDS -->
            @php
                $previewSocialStyle = $templateConfig['social_style'] ?? 'pills';
                $previewButtonStyle = $templateConfig['button_style'] ?? 'rounded';
                $previewIsBold = ($headerStyle === 'bold');
                $previewBodyBg = $previewIsBold ? '#E8E6E3' : 'white';
                $previewBlockBg = $previewIsBold ? '#DFDDD9' : '#F9FAFB';
                $previewBlockBorder = $previewIsBold ? ($primary_color . '50') : '#E5E7EB';
                $previewBtnRadius = match($previewButtonStyle) {
                    'square' => 'rounded-md',
                    'square_wide' => 'rounded-none',
                    'outline_compact' => 'rounded-full',
                    default => 'rounded-xl',
                };
            @endphp
            <div class="relative" style="background: {{ $previewBodyBg }}; margin-top: -1px; z-index: 1;">
                <div class="px-5 py-6 space-y-3">
                    @php
                        $visibleBands = collect($contentBands)->filter(fn($b) => !($b['is_hidden'] ?? false));
                        $previewRenderedSocialIds = [];
                    @endphp
                    
                    @foreach($visibleBands as $bandIndex => $band)

                        @if($band['type'] === 'contact_button')
                            @if($previewButtonStyle === 'outline_compact')
                                <div class="text-center">
                                    <div class="inline-flex items-center justify-center space-x-2 py-2.5 px-8 rounded-full font-semibold text-sm"
                                         style="font-family: 'Manrope', sans-serif; background: transparent; color: {{ $secondary_color }}; border: 2px solid {{ $secondary_color }};">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-8 2.75c1.24 0 2.25 1.01 2.25 2.25s-1.01 2.25-2.25 2.25S9.75 10.24 9.75 9s1.01-2.25 2.25-2.25zM17 17H7v-1.5c0-1.67 3.33-2.5 5-2.5s5 .83 5 2.5V17z"/></svg>
                                        <span>Ajouter aux contacts</span>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center justify-center space-x-2 w-full {{ $previewButtonStyle === 'square_wide' ? 'py-4 px-5' : 'py-3.5 px-5' }} text-white text-center {{ $previewBtnRadius }} font-semibold {{ $previewButtonStyle === 'square_wide' ? 'text-base tracking-wide' : 'text-sm' }} shadow-md"
                                     style="font-family: 'Manrope', sans-serif; background: {{ $secondary_color }};">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-8 2.75c1.24 0 2.25 1.01 2.25 2.25s-1.01 2.25-2.25 2.25S9.75 10.24 9.75 9s1.01-2.25 2.25-2.25zM17 17H7v-1.5c0-1.67 3.33-2.5 5-2.5s5 .83 5 2.5V17z"/></svg>
                                    <span>Ajouter aux contacts</span>
                                </div>
                            @endif

                        @elseif($band['type'] === 'social_link')
                            @if(!in_array($band['id'], $previewRenderedSocialIds))
                                @php
                                    // Collect consecutive social links from this position
                                    $consecutivePreviewSocials = collect();
                                    $foundCurrent = false;
                                    foreach ($visibleBands as $checkBand) {
                                        if ($checkBand['id'] === $band['id']) {
                                            $foundCurrent = true;
                                            $consecutivePreviewSocials->push($checkBand);
                                            $previewRenderedSocialIds[] = $checkBand['id'];
                                        } elseif ($foundCurrent && $checkBand['type'] === 'social_link') {
                                            $consecutivePreviewSocials->push($checkBand);
                                            $previewRenderedSocialIds[] = $checkBand['id'];
                                        } elseif ($foundCurrent) {
                                            break;
                                        }
                                    }
                                @endphp

                                @if($previewSocialStyle === 'circles')
                                    <div class="flex flex-wrap justify-center gap-3 py-2">
                                        @foreach($consecutivePreviewSocials as $sBand)
                                            <div class="w-11 h-11 rounded-full flex items-center justify-center shadow-sm"
                                                 style="background: {{ $previewBlockBg }}; border: 1px solid {{ $previewBlockBorder }};">
                                                <x-social-icon :platform="$sBand['data']['platform'] ?? ''" size="w-5 h-5" />
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif($previewSocialStyle === 'pills')
                                    <div class="flex flex-wrap justify-center gap-2 py-1">
                                        @foreach($consecutivePreviewSocials as $sBand)
                                            <div class="inline-flex items-center gap-2 px-4 py-2.5 {{ $previewBtnRadius }}"
                                                 style="background: {{ $previewBlockBg }}; border: 1px solid {{ $previewBlockBorder }};">
                                                <x-social-icon :platform="$sBand['data']['platform'] ?? ''" size="w-4 h-4" />
                                                <span class="font-medium text-xs" style="color: #2C2A27;">{{ ucfirst($sBand['data']['platform'] ?? '') }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    @foreach($consecutivePreviewSocials as $sBand)
                                        <div class="p-3.5 {{ $previewBtnRadius }}" style="background: {{ $previewBlockBg }}; border: 1px solid {{ $previewBlockBorder }};">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-8 h-8 flex items-center justify-center">
                                                    <x-social-icon :platform="$sBand['data']['platform'] ?? ''" size="w-6 h-6" />
                                                </div>
                                                <span class="font-medium text-sm" style="font-family: 'Manrope', sans-serif; color: {{ $previewIsBold ? '#4B5563' : '#2C2A27' }};">{{ ucfirst($sBand['data']['platform'] ?? '') }}</span>
                                                <svg class="w-4 h-4 ml-auto" fill="#9CA3AF" viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @endif

                        @elseif($band['type'] === 'image')
                            @php
                                $images = $band['data']['images'] ?? [];
                                if (empty($images) && isset($band['data']['path'])) {
                                    $images = [['path' => $band['data']['path'], 'link' => $band['data']['link'] ?? '']];
                                }
                            @endphp
                            @if(count($images) === 1)
                                <div class="{{ $previewBtnRadius }} overflow-hidden" style="border: 1px solid {{ $previewBlockBorder }};">
                                    <img src="{{ Storage::url($images[0]['path']) }}" class="w-full h-auto object-contain" style="max-height: 200px;">
                                </div>
                            @elseif(count($images) >= 2)
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach(array_slice($images, 0, 2) as $img)
                                        <div class="{{ $previewBtnRadius }} overflow-hidden" style="border: 1px solid {{ $previewBlockBorder }};">
                                            <img src="{{ Storage::url($img['path']) }}" class="w-full h-auto object-contain" style="max-height: 150px;">
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                        @elseif($band['type'] === 'text_block')
                            <div class="p-4 rounded-xl" style="background: {{ $previewBlockBg }}; border: 1px solid {{ $previewBlockBorder }};">
                                <p class="whitespace-pre-line text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">{{ $band['data']['text'] ?? '' }}</p>
                            </div>

                        @elseif($band['type'] === 'video_embed')
                            <div class="rounded-xl overflow-hidden" style="border: 1px solid {{ $previewBlockBorder }}; background: #000;">
                                <div class="flex items-center justify-center py-8">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: rgba(255,0,0,0.8);">
                                        <svg class="w-4 h-4" fill="white" viewBox="0 0 24 24"><polygon points="9,6 19,12 9,18"/></svg>
                                    </div>
                                </div>
                            </div>

                        @elseif($band['type'] === 'cta_button')
                            @php
                                $pBtnBg = $band['data']['bg_color'] ?? $profile->button_color ?? $secondary_color;
                                $pHex = ltrim($pBtnBg, '#');
                                $pBtnText = '#FFFFFF';
                                if (strlen($pHex) === 6) {
                                    $pR = hexdec(substr($pHex, 0, 2)); $pG = hexdec(substr($pHex, 2, 2)); $pB = hexdec(substr($pHex, 4, 2));
                                    $pBtnText = ((0.299 * $pR + 0.587 * $pG + 0.114 * $pB) / 255 > 0.6) ? '#2C2A27' : '#FFFFFF';
                                }
                            @endphp
                            <div class="flex items-center justify-center space-x-2 w-full {{ $previewButtonStyle === 'square_wide' ? 'py-4 px-5' : 'py-3.5 px-5' }} text-center {{ $previewBtnRadius }} font-semibold {{ $previewButtonStyle === 'square_wide' ? 'text-base tracking-wide' : 'text-sm' }} shadow-md"
                                 style="font-family: 'Manrope', sans-serif; background: {{ $pBtnBg }}; color: {{ $pBtnText }};">
                                @if(!empty($band['data']['icon']))<span>{{ $band['data']['icon'] }}</span>@endif
                                <span>{{ $band['data']['label'] ?? 'Lien' }}</span>
                            </div>

                        @elseif($band['type'] === 'image_carousel')
                            <div class="{{ $previewBtnRadius }} overflow-hidden" style="border: 1px solid {{ $previewBlockBorder }};">
                                @php $carImages = $band['data']['images'] ?? []; @endphp
                                @if(count($carImages) > 0)
                                    <img src="{{ Storage::url($carImages[0]['path']) }}" class="w-full h-auto object-contain" style="max-height: 180px;">
                                    <div class="flex justify-center gap-1 py-1.5">
                                        @foreach($carImages as $idx => $ci)
                                            <div class="w-1.5 h-1.5 rounded-full" style="background: {{ $idx === 0 ? '#2C2A27' : '#D1D5DB' }};"></div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif

                    @endforeach

                    @if($visibleBands->count() === 0)
                        <div class="py-8 text-center">
                            <p class="text-sm" style="color: #D1D5DB;">Votre contenu apparaîtra ici</p>
                        </div>
                    @endif
                </div>

                <div class="px-5 pb-6 pt-3 text-center" style="border-top: 1px solid #E5E7EB;">
                    <p class="text-xs" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">
                        Propulsé par <span class="font-semibold" style="color: #6B7280;">Link-Card</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
