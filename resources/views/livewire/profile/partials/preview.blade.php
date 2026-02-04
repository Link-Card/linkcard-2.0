<!-- Font Awesome fallback -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<div class="sticky top-6">
    <p class="text-xs text-center mb-3 font-medium uppercase tracking-wider"
       style="font-family: 'Manrope', sans-serif; color: #9CA3AF; letter-spacing: 0.08em;">
        Aperçu en direct
    </p>
    <div class="rounded-2xl overflow-hidden" style="box-shadow: 0 8px 32px rgba(0,0,0,0.12); border: 1px solid #E5E7EB;">
        <div class="overflow-y-auto" style="max-height: calc(100vh - 120px); background: #F7F8F4;">

            <!-- HEADER GRADIENT -->
            <div style="background: linear-gradient(180deg, {{ $primary_color }} 0%, {{ $secondary_color }} 100%);">
                <div class="px-6 pt-10 pb-6 text-center" style="color: {{ $headerTextColor }};">
                    @if($profile->photo_path)
                        <img src="{{ Storage::url($profile->photo_path) }}" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-xl mx-auto mb-4">
                    @else
                        <div class="w-24 h-24 rounded-full bg-white/30 border-4 border-white shadow-xl mx-auto mb-4 flex items-center justify-center">
                            <span class="text-4xl">👤</span>
                        </div>
                    @endif

                    <h2 class="text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; letter-spacing: -0.02em;">
                        {{ $full_name ?: 'Votre nom' }}
                    </h2>

                    @if($job_title)
                        <p class="text-base font-medium mt-1" style="font-family: 'Manrope', sans-serif; opacity: 0.9;">{{ $job_title }}</p>
                    @endif

                    @if($company || $location)
                        <p class="text-sm mt-1" style="font-family: 'Manrope', sans-serif; opacity: 0.8;">
                            @if($company && $location)
                                {{ $company }} · {{ $location }}
                            @else
                                {{ $company }}{{ $location }}
                            @endif
                        </p>
                    @endif

                    @if($phone || $email)
                        <div class="mt-3 space-y-0.5">
                            @if($phone)
                                <p class="text-sm" style="font-family: 'Manrope', sans-serif; opacity: 0.85;">{{ $phone }}</p>
                            @endif
                            @if($email)
                                <p class="text-sm" style="font-family: 'Manrope', sans-serif; opacity: 0.85;">{{ $email }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- CONTENT BANDS -->
            <div class="bg-white">
                <div class="px-5 py-6 space-y-3">
                    @foreach($contentBands as $band)

                        @if($band['type'] === 'contact_button')
                            <div class="block w-full py-3.5 px-5 text-white text-center rounded-xl font-semibold text-sm shadow-md"
                                 style="font-family: 'Manrope', sans-serif; background: {{ $secondary_color }}; border: 1px solid rgba(0,0,0,0.1);">
                                <i class="fas fa-address-book mr-2"></i>Ajouter aux contacts
                            </div>

                        @elseif($band['type'] === 'social_link')
                            @php $p = $band['data']['platform'] ?? ''; @endphp
                            <div class="p-3.5 rounded-xl transition" style="background: #F9FAFB; border: 1px solid #E5E7EB;">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center">
                                        @if($p === 'Facebook') <i class="fab fa-facebook text-xl" style="color: #1877F2;"></i>
                                        @elseif($p === 'Instagram') <i class="fab fa-instagram text-xl" style="color: #E4405F;"></i>
                                        @elseif($p === 'LinkedIn') <i class="fab fa-linkedin text-xl" style="color: #0A66C2;"></i>
                                        @elseif($p === 'Twitter') <i class="fab fa-x-twitter text-xl" style="color: #000;"></i>
                                        @elseif($p === 'TikTok') <i class="fab fa-tiktok text-xl" style="color: #000;"></i>
                                        @elseif($p === 'YouTube') <i class="fab fa-youtube text-xl" style="color: #FF0000;"></i>
                                        @elseif($p === 'GitHub') <i class="fab fa-github text-xl" style="color: #181717;"></i>
                                        @elseif($p === 'Snapchat') <i class="fab fa-snapchat text-xl" style="color: #FFFC00;"></i>
                                        @elseif($p === 'Pinterest') <i class="fab fa-pinterest text-xl" style="color: #E60023;"></i>
                                        @elseif($p === 'WhatsApp') <i class="fab fa-whatsapp text-xl" style="color: #25D366;"></i>
                                        @elseif($p === 'Telegram') <i class="fab fa-telegram text-xl" style="color: #0088cc;"></i>
                                        @elseif($p === 'Discord') <i class="fab fa-discord text-xl" style="color: #5865F2;"></i>
                                        @elseif($p === 'Twitch') <i class="fab fa-twitch text-xl" style="color: #9146FF;"></i>
                                        @elseif($p === 'Spotify') <i class="fab fa-spotify text-xl" style="color: #1DB954;"></i>
                                        @elseif($p === 'Apple Music') <i class="fab fa-apple text-xl" style="color: #000;"></i>
                                        @elseif($p === 'SoundCloud') <i class="fab fa-soundcloud text-xl" style="color: #FF5500;"></i>
                                        @else <i class="fas fa-link text-xl" style="color: #6B7280;"></i>
                                        @endif
                                    </div>
                                    <span class="font-medium text-sm" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">{{ $p ?: 'Lien' }}</span>
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
                                <p class="whitespace-pre-line text-sm leading-relaxed" style="font-family: 'Manrope', sans-serif; color: #4B5563;">{{ $band['data']['text'] ?? '' }}</p>
                            </div>
                        @endif

                    @endforeach

                    @if(count($contentBands) === 0)
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
