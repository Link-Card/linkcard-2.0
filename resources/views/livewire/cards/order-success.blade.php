<div class="p-8">
    <div class="max-w-lg mx-auto">
        <div class="bg-white rounded-xl shadow-sm p-8 text-center">
            <!-- Success icon -->
            <div class="w-16 h-16 mx-auto mb-6 rounded-full flex items-center justify-center" style="background-color: #F0F9F4;">
                <svg class="w-8 h-8" style="color: #42B574;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <h1 class="text-2xl font-semibold mb-2" style="color: #2C2A27;">Commande confirmée !</h1>

            <p class="text-sm mb-6" style="color: #4B5563;">
                Votre commande de {{ $order->quantity }} carte(s) NFC a été reçue.
            </p>

            <!-- Order details -->
            <div class="rounded-lg p-4 mb-6 text-left" style="background-color: #F7F8F4;">
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span style="color: #4B5563;">Commande</span>
                        <span class="font-medium" style="color: #2C2A27;">#{{ $order->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span style="color: #4B5563;">Total</span>
                        <span class="font-semibold" style="color: #42B574;">{{ $order->amount_dollars }}$</span>
                    </div>
                </div>

                @if($order->items)
                    <div class="mt-3 pt-3" style="border-top: 1px solid #E5E7EB;">
                        @foreach($order->items as $item)
                            <div class="flex justify-between items-center py-1">
                                <span class="text-sm" style="color: #2C2A27;">{{ $item['profile_name'] ?? 'Profil' }}</span>
                                <span class="text-xs" style="color: #4B5563;">{{ $item['quantity'] }} carte(s) · {{ ($item['design_type'] ?? 'standard') === 'custom' ? 'Personnalisé' : 'Standard' }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Shipping info -->
            <div class="rounded-lg p-4 mb-6 text-left" style="background-color: #F0F9F4;">
                <p class="text-sm font-medium mb-1" style="color: #2D7A4F;">Livraison</p>
                <p class="text-xs" style="color: #4B5563;">
                    {{ $order->shipping_address['name'] ?? '' }}<br>
                    {{ $order->shipping_address['street'] ?? '' }}<br>
                    {{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['province'] ?? '' }} {{ $order->shipping_address['postal_code'] ?? '' }}
                </p>
                <p class="text-xs mt-2" style="color: #9CA3AF;">Délai estimé: 5-10 jours ouvrables</p>
            </div>

            <!-- Next steps -->
            <div class="rounded-lg p-4 mb-6 text-left" style="background-color: #EFF6FF;">
                <p class="text-sm font-medium mb-2" style="color: #4A7FBF;">Prochaines étapes</p>
                <ol class="text-xs space-y-1" style="color: #4B5563;">
                    <li>1. Nous préparons vos cartes</li>
                    <li>2. Vous recevez un email quand elles sont expédiées</li>
                    <li>3. Vos cartes sont déjà liées à vos profils</li>
                    <li>4. Partagez vos profils d'un simple tap!</li>
                </ol>
            </div>

            <!-- Actions -->
            <div class="space-y-3">
                <a href="{{ route('cards.index') }}" class="block w-full py-3 px-4 rounded-lg text-white font-medium text-center transition-colors" style="background-color: #42B574;" onmouseover="this.style.backgroundColor='#3DA367'" onmouseout="this.style.backgroundColor='#42B574'">
                    Voir mes cartes
                </a>
                <a href="{{ route('dashboard') }}" class="block w-full py-3 px-4 rounded-lg font-medium text-center text-sm transition-colors" style="color: #4B5563; border: 1px solid #D1D5DB;" onmouseover="this.style.backgroundColor='#F3F4F6'" onmouseout="this.style.backgroundColor='transparent'">
                    Retour au tableau de bord
                </a>
            </div>
        </div>
    </div>
</div>
