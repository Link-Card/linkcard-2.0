<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    @if(session()->has('success'))
        <div class="m-4 p-3 rounded-lg" style="background-color: #F0F9F4; border: 1px solid #42B574; color: #2D7A4F;">
            {{ session('success') }}
        </div>
    @endif

    @include('livewire.admin.partials.delete-modal')

    @if($archivedOrders->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr style="background-color: #F7F8F4;">
                        <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">#</th>
                        <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">Client</th>
                        <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">Cartes</th>
                        <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">Total</th>
                        <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">Date</th>
                        <th class="text-right px-4 py-3 text-xs font-medium" style="color: #4B5563;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($archivedOrders as $order)
                        <tr class="border-t" style="border-color: #E5E7EB;">
                            <td class="px-4 py-3 text-sm font-mono" style="color: #9CA3AF;">{{ $order->order_number ?? '#'.$order->id }}</td>
                            <td class="px-4 py-3">
                                <p class="text-sm" style="color: #4B5563;">{{ $order->user->name ?? 'Supprimé' }}</p>
                                <p class="text-xs" style="color: #9CA3AF;">{{ $order->user->email ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3 text-sm" style="color: #4B5563;">{{ $order->quantity }}</td>
                            <td class="px-4 py-3 text-sm" style="color: #4B5563;">{{ $order->amount_dollars }}$</td>
                            <td class="px-4 py-3 text-xs" style="color: #9CA3AF;">{{ $order->created_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end space-x-2">
                                    <button wire:click="startEdit({{ $order->id }})"
                                            class="px-4 py-2 text-xs rounded-xl font-medium transition-all"
                                            style="background-color: #F3F4F6; color: #4B5563; border: 1.5px solid #9CA3AF;">
                                        Détails
                                    </button>
                                    <button wire:click="unarchiveOrder({{ $order->id }})"
                                            class="px-4 py-2 text-xs rounded-xl font-medium transition-all"
                                            style="background-color: #EFF6FF; color: #4A7FBF; border: 1.5px solid #4A7FBF;">
                                        Restaurer
                                    </button>
                                    <button wire:click="confirmDelete({{ $order->id }})"
                                            class="px-4 py-2 text-xs rounded-xl font-medium transition-all"
                                            style="background-color: #FEF2F2; color: #EF4444; border: 1.5px solid #EF4444;">
                                        Supprimer
                                    </button>
                                </div>
                            </td>
                        </tr>

                        {{-- Expanded detail --}}
                        @if($editingOrderId === $order->id)
                            <tr style="background-color: #F7F8F4;">
                                <td colspan="6" class="px-4 py-5">
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                                        <div>
                                            @if($order->items)
                                                @foreach($order->items as $item)
                                                    <div class="p-4 rounded-xl bg-white mb-3 shadow-sm">
                                                        <div class="flex justify-between items-center mb-1">
                                                            <span class="text-sm font-semibold" style="color: #2C2A27;">{{ $item['profile_name'] ?? 'Profil' }}</span>
                                                            <span class="text-xs px-2.5 py-1 rounded-full font-medium" style="background-color: #F3F4F6; color: #4B5563;">
                                                                {{ $item['quantity'] }} carte(s) · {{ ($item['design_type'] ?? 'standard') === 'custom' ? 'Custom' : 'Standard' }}
                                                            </span>
                                                        </div>
                                                        <div class="flex items-center space-x-2 mt-2">
                                                            <span class="text-xs" style="color: #9CA3AF;">Code:</span>
                                                            <code class="text-sm font-bold font-mono px-2 py-0.5 rounded" style="color: #2C2A27; background-color: #F3F4F6;">{{ $item['card_code'] ?? '' }}</code>
                                                        </div>
                                                        <div class="flex items-center space-x-2 mt-1">
                                                            <span class="text-xs" style="color: #9CA3AF;">NFC →</span>
                                                            <code class="text-xs font-mono" style="color: #4A7FBF;">https://app.linkcard.ca/c/{{ $item['card_code'] ?? '' }}</code>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif

                                            @if($order->logo_path)
                                                <div class="p-4 rounded-xl bg-white mt-3 shadow-sm">
                                                    <div class="flex justify-between items-center mb-2">
                                                        <p class="text-sm font-medium" style="color: #2C2A27;">🎨 Logo</p>
                                                        <a href="{{ asset('storage/' . $order->logo_path) }}" download="logo-commande-{{ $order->id }}.png"
                                                           class="px-3 py-1.5 text-xs rounded-xl font-medium"
                                                           style="background-color: #F0F9F4; color: #42B574; border: 1.5px solid #42B574;">
                                                            ⬇ Télécharger
                                                        </a>
                                                    </div>
                                                    <div class="rounded-xl overflow-hidden inline-block p-2" style="background: repeating-conic-gradient(#f3f4f6 0% 25%, #fff 0% 50%) 50% / 14px 14px;">
                                                        <img src="{{ asset('storage/' . $order->logo_path) }}" class="h-20 object-contain">
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <div>
                                            @if($order->shipping_address)
                                                <div class="p-4 rounded-xl bg-white shadow-sm">
                                                    <p class="text-sm font-medium mb-2" style="color: #2C2A27;">📦 Adresse</p>
                                                    <p class="text-sm font-medium" style="color: #2C2A27;">{{ $order->shipping_address['name'] ?? '' }}</p>
                                                    <p class="text-sm" style="color: #4B5563;">{{ $order->shipping_address['street'] ?? '' }}</p>
                                                    <p class="text-sm" style="color: #4B5563;">{{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['province'] ?? '' }} {{ $order->shipping_address['postal_code'] ?? '' }}</p>
                                                    <p class="text-sm mt-1" style="color: #4B5563;">📞 {{ $order->shipping_address['phone'] ?? '' }}</p>
                                                </div>
                                            @endif

                                            @if($order->tracking_number)
                                                <div class="p-4 rounded-xl bg-white shadow-sm mt-3">
                                                    <p class="text-sm font-medium mb-1" style="color: #2C2A27;">🚚 Suivi</p>
                                                    <code class="text-sm font-mono" style="color: #4B5563;">{{ $order->tracking_number }}</code>
                                                </div>
                                            @endif

                                            <button wire:click="cancelEdit" class="mt-4 w-full px-5 py-3 text-sm rounded-xl font-medium" style="color: #4B5563; border: 1.5px solid #D1D5DB;">
                                                Fermer
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="p-8 text-center">
            <svg class="w-12 h-12 mx-auto mb-3" style="color: #D1D5DB;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
            </svg>
            <p class="text-sm" style="color: #9CA3AF;">Aucune commande archivée.</p>
            <p class="text-xs mt-1" style="color: #D1D5DB;">Les commandes livrées sont auto-archivées après 30 jours.</p>
        </div>
    @endif
</div>
