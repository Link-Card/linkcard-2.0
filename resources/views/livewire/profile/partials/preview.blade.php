<div class="sticky top-6">
    <p class="text-xs text-center mb-3 font-medium uppercase tracking-wider"
       style="font-family: 'Manrope', sans-serif; color: #9CA3AF; letter-spacing: 0.08em;">
        Aperçu en direct
    </p>
    <div class="rounded-2xl overflow-hidden" style="box-shadow: 0 8px 32px rgba(0,0,0,0.12); border: 1px solid #E5E7EB;">
        <div class="overflow-y-auto" style="max-height: calc(100vh - 120px); background: #F7F8F4;">

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
                    <div class="absolute bottom-0 left-0 right-0" style="height: 4px; background: linear-gradient(90deg, {{ $primary_color }}, {{ $secondary_color }});"></div>
                    <div class="px-6 pt-10 pb-6 text-center" style="color: #FFFFFF;">
                        @include('livewire.profile.partials.preview-photo', ['photoStyle' => $photoStyle, 'borderStyle' => "border: 3px solid {$primary_color};"])
                        @include('livewire.profile.partials.preview-info', ['textColor' => '#FFFFFF'])
                    </div>
                </div>
            @elseif($headerStyle === 'minimal')
                <div style="height: 5px; background: linear-gradient(90deg, {{ $primary_color }}, {{ $secondary_color }});"></div>
                <div class="bg-white px-6 pt-8 pb-6 text-center">
                    @include('livewire.profile.partials.preview-photo', ['photoStyle' => $photoStyle, 'shadowColor' => $primary_color])
                    @include('livewire.profile.partials.preview-info', ['textColor' => '#2C2A27'])
                </div>
            @elseif($headerStyle === 'banner')
                <div style="height: 100px; background: linear-gradient(135deg, {{ $primary_color }}, {{ $secondary_color }});"></div>
                <div class="bg-white text-center pb-4">
                    <div class="flex justify-center">
                        @if($profile->photo_path)
                            <img src="{{ Storage::url($profile->photo_path) }}" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-xl" style="margin-top: -48px;">
                        @else
                            <div class="w-24 h-24 rounded-full border-4 border-white shadow-xl flex items-center justify-center" style="margin-top: -48px; background: linear-gradient(135deg, {{ $primary_color }}, {{ $secondary_color }});">
                                <span class="text-4xl">👤</span>
                            </div>
                        @endif
                    </div>
                    <div class="mt-3 px-6">
                        @include('livewire.profile.partials.preview-info', ['textColor' => '#2C2A27'])
                    </div>
                </div>
            @elseif($headerStyle === 'split')
                <div style="background: linear-gradient(180deg, {{ $primary_color }}, {{ $secondary_color }});">
                    <div class="flex">
                        <div class="w-[38%] flex items-center justify-center py-10" style="background: {{ $primary_color }};">
                            @if($profile->photo_path)
                                <img src="{{ Storage::url($profile->photo_path) }}" class="w-20 h-20 rounded-full object-cover border-3 border-white shadow-xl">
                            @else
                                <div class="w-20 h-20 rounded-full bg-white/30 border-3 border-white shadow-xl flex items-center justify-center">
                                    <span class="text-3xl">👤</span>
                                </div>
                            @endif
                        </div>
                        <div class="w-[62%] flex flex-col justify-center py-10 px-4" style="background: linear-gradient(180deg, {{ $secondary_color }}, {{ $primary_color }}); color: {{ $headerTextColor }};">
                            <h2 class="text-lg font-semibold" style="font-family: 'Manrope', sans-serif;">{{ $full_name ?: 'Votre nom' }}</h2>
                            @if($job_title)<p class="text-xs font-medium mt-1" style="opacity: 0.9;">{{ $job_title }}</p>@endif
                            @if($company || $location)<p class="text-xs mt-0.5" style="opacity: 0.8;">{{ $company }}@if($company && $location) · @endif{{ $location }}</p>@endif
                        </div>
                    </div>
                    @include('livewire.profile.partials.preview-transition', ['transition' => 'wave'])
                </div>
            @elseif($headerStyle === 'geometric')
                <div class="relative overflow-hidden" style="background: linear-gradient(135deg, {{ $primary_color }}, {{ $secondary_color }});">
                    <div class="absolute" style="top: 10px; left: -20px; width: 80px; height: 80px; border-radius: 50%; background: rgba(255,255,255,0.07);"></div>
                    <div class="absolute" style="top: -15px; right: 20px; width: 100px; height: 100px; border-radius: 50%; background: rgba(255,255,255,0.05);"></div>
                    <div class="relative z-10 px-6 pt-10 pb-2 text-center" style="color: {{ $headerTextColor }};">
                        @include('livewire.profile.partials.preview-photo', ['photoStyle' => 'square_center'])
                        @include('livewire.profile.partials.preview-info', ['textColor' => $headerTextColor])
                    </div>
                    @include('livewire.profile.partials.preview-transition', ['transition' => 'chevron'])
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
            <div class="bg-white">
                <div class="px-5 py-6 space-y-3">
                    @php $visibleBands = collect($contentBands)->filter(fn($b) => !($b['is_hidden'] ?? false)); @endphp
                    
                    @foreach($visibleBands as $band)

                        @if($band['type'] === 'contact_button')
                            <div class="flex items-center justify-center space-x-2 w-full py-3.5 px-5 text-white text-center rounded-xl font-semibold text-sm shadow-md"
                                 style="font-family: 'Manrope', sans-serif; background: {{ $secondary_color }};">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-8 2.75c1.24 0 2.25 1.01 2.25 2.25s-1.01 2.25-2.25 2.25S9.75 10.24 9.75 9s1.01-2.25 2.25-2.25zM17 17H7v-1.5c0-1.67 3.33-2.5 5-2.5s5 .83 5 2.5V17z"/></svg>
                                <span>Ajouter aux contacts</span>
                            </div>

                        @elseif($band['type'] === 'social_link')
                            <div class="p-3.5 rounded-xl" style="background: #F9FAFB; border: 1px solid #E5E7EB;">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 flex items-center justify-center">
                                        <x-social-icon :platform="$band['data']['platform'] ?? ''" size="w-6 h-6" />
                                    </div>
                                    <span class="font-medium text-sm" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">{{ $band['data']['platform'] ?? 'Lien' }}</span>
                                </div>
                            </div>

                        @elseif($band['type'] === 'image')
                            @php
                                $images = $band['data']['images'] ?? [];
                                if (empty($images) && isset($band['data']['path'])) {
                                    $images = [['path' => $band['data']['path'], 'link' => $band['data']['link'] ?? '']];
                                }
                            @endphp
                            @if(count($images) === 1)
                                <div class="rounded-xl overflow-hidden" style="border: 1px solid #E5E7EB;">
                                    <img src="{{ Storage::url($images[0]['path']) }}" class="w-full h-auto object-contain" style="max-height: 200px;">
                                </div>
                            @elseif(count($images) >= 2)
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach(array_slice($images, 0, 2) as $img)
                                        <div class="rounded-xl overflow-hidden" style="border: 1px solid #E5E7EB;">
                                            <img src="{{ Storage::url($img['path']) }}" class="w-full h-auto object-contain" style="max-height: 150px;">
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                        @elseif($band['type'] === 'text_block')
                            <div class="p-4 rounded-xl" style="background: #F9FAFB; border: 1px solid #E5E7EB;">
                                <p class="whitespace-pre-line text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">{{ $band['data']['text'] ?? '' }}</p>
                            </div>

                        @elseif($band['type'] === 'video_embed')
                            <div class="rounded-xl overflow-hidden" style="border: 1px solid #E5E7EB; background: #000;">
                                <div class="flex items-center justify-center py-8">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: rgba(255,0,0,0.8);">
                                        <svg class="w-4 h-4" fill="white" viewBox="0 0 24 24"><polygon points="9,6 19,12 9,18"/></svg>
                                    </div>
                                </div>
                            </div>

                        @elseif($band['type'] === 'cta_button')
                            <div class="flex items-center justify-center space-x-2 w-full py-3.5 px-5 text-white text-center rounded-xl font-semibold text-sm shadow-md"
                                 style="font-family: 'Manrope', sans-serif; background: {{ $profile->button_color ?? $secondary_color }};">
                                @if(!empty($band['data']['icon']))<span>{{ $band['data']['icon'] }}</span>@endif
                                <span>{{ $band['data']['label'] ?? 'Lien' }}</span>
                            </div>

                        @elseif($band['type'] === 'image_carousel')
                            <div class="rounded-xl overflow-hidden" style="border: 1px solid #E5E7EB;">
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
