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
        
        /* Share Button */
        .share-btn {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #42B574;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(66, 181, 116, 0.4);
        }
        .share-btn:hover { 
            transform: scale(1.05); 
            background: #3DA367;
            box-shadow: 0 4px 12px rgba(66, 181, 116, 0.5);
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
    </style>
</head>
<body class="min-h-screen" style="background: #F7F8F4;">

    @php
        $primaryColor = $profile->primary_color ?? '#42B574';
        $secondaryColor = $profile->secondary_color ?? '#2D7A4F';
        $profileUrl = url()->current();
        $userPlan = $profile->user->plan ?? 'free';
        $canShowQR = in_array($userPlan, ['pro', 'premium']);
        
        // Calculer si le texte doit être clair ou foncé
        $hex = ltrim($primaryColor, '#');
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
        $headerTextColor = $luminance > 0.6 ? '#2C2A27' : '#FFFFFF';
    @endphp

    <div class="max-w-md mx-auto min-h-screen relative">

        <!-- HEADER GRADIENT -->
        <div class="relative" style="background: linear-gradient(180deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);">
            
            <!-- Bouton Partage -->
            <button class="share-btn" onclick="openSharePopup()" style="position: absolute; top: 16px; right: 16px; z-index: 10;">
                <svg viewBox="0 0 24 24"><path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92s2.92-1.31 2.92-2.92-1.31-2.92-2.92-2.92z"/></svg>
            </button>
            
            <div class="px-6 pt-12 pb-8 text-center" style="color: {{ $headerTextColor }};">

                <!-- Photo -->
                <div class="flex justify-center mb-5">
                    @if($profile->photo_path)
                        <img src="{{ Storage::url($profile->photo_path) }}"
                             class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-xl">
                    @else
                        <div class="w-28 h-28 rounded-full bg-white/30 border-4 border-white shadow-xl flex items-center justify-center">
                            <span class="text-5xl">👤</span>
                        </div>
                    @endif
                </div>

                <!-- Nom -->
                <h1 class="text-2xl font-semibold" style="letter-spacing: -0.02em;">{{ $profile->full_name }}</h1>

                <!-- Titre -->
                @if($profile->job_title)
                    <p class="text-base font-medium mt-1" style="opacity: 0.9;">{{ $profile->job_title }}</p>
                @endif

                <!-- Entreprise + Lieu -->
                @if($profile->company || $profile->location)
                    <p class="text-sm mt-1" style="opacity: 0.8;">
                        {{ $profile->company }}@if($profile->company && $profile->location) · @endif{{ $profile->location }}
                    </p>
                @endif

                <!-- Téléphone + Email -->
                @if($profile->phone || $profile->email)
                    <div class="mt-4 space-y-1">
                        @if($profile->phone)
                            <a href="tel:{{ $profile->phone }}" class="block text-sm hover:underline" style="opacity: 0.85;">
                                {{ $profile->phone }}
                            </a>
                        @endif
                        @if($profile->email)
                            <a href="mailto:{{ $profile->email }}" class="block text-sm hover:underline" style="opacity: 0.85;">
                                {{ $profile->email }}
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- CONTENT BANDS -->
        <div class="bg-white min-h-[200px]">
            <div class="px-5 py-6 space-y-3">

                @foreach($profile->contentBands as $band)

                    @if($band->type === 'contact_button')
                        <!-- Bouton vCard -->
                        <a href="{{ route('profile.vcard', $profile) }}"
                           class="flex items-center justify-center space-x-2 w-full py-3.5 px-5 text-white text-center rounded-xl font-semibold text-sm shadow-md transition-all duration-200"
                           style="background: {{ $secondaryColor }};"
                           onmouseover="this.style.opacity='0.9'; this.style.transform='translateY(-1px)'"
                           onmouseout="this.style.opacity='1'; this.style.transform='translateY(0)'">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-8 2.75c1.24 0 2.25 1.01 2.25 2.25s-1.01 2.25-2.25 2.25S9.75 10.24 9.75 9s1.01-2.25 2.25-2.25zM17 17H7v-1.5c0-1.67 3.33-2.5 5-2.5s5 .83 5 2.5V17z"/></svg>
                            <span>Ajouter aux contacts</span>
                        </a>

                    @elseif($band->type === 'social_link')
                        <!-- Lien social -->
                        <a href="{{ $band->data['url'] }}" target="_blank" rel="noopener"
                           class="block p-3.5 rounded-xl transition-all duration-200"
                           style="background: #F9FAFB; border: 1px solid #E5E7EB;"
                           onmouseover="this.style.background='#F3F4F6'; this.style.borderColor='#D1D5DB'"
                           onmouseout="this.style.background='#F9FAFB'; this.style.borderColor='#E5E7EB'">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 flex items-center justify-center">
                                    <x-social-icon :platform="$band->data['platform'] ?? ''" size="w-6 h-6" />
                                </div>
                                <span class="font-medium text-sm" style="color: #2C2A27;">{{ $band->data['platform'] }}</span>
                                <svg class="w-4 h-4 ml-auto" fill="#9CA3AF" viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
                            </div>
                        </a>

                    @elseif($band->type === 'image')
                        <!-- Image(s) -->
                        @php
                            $images = $band->data['images'] ?? [];
                            if (empty($images) && isset($band->data['path'])) {
                                $images = [['path' => $band->data['path'], 'link' => $band->data['link'] ?? '']];
                            }
                        @endphp
                        
                        @if(count($images) === 1)
                            <div class="rounded-xl overflow-hidden" style="border: 1px solid #E5E7EB;">
                                @if(!empty($images[0]['link']))
                                    <a href="{{ $images[0]['link'] }}" target="_blank" rel="noopener">
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
                                    <div class="rounded-xl overflow-hidden" style="border: 1px solid #E5E7EB;">
                                        @if(!empty($img['link']))
                                            <a href="{{ $img['link'] }}" target="_blank" rel="noopener">
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
                        <div class="p-4 rounded-xl" style="background: #F9FAFB; border: 1px solid #E5E7EB;">
                            <p class="whitespace-pre-line text-sm leading-relaxed" style="color: #4B5563;">{{ $band->data['text'] }}</p>
                        </div>

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
    </script>

</body>
</html>
