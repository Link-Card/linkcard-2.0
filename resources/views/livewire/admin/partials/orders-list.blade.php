<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    @if(session()->has('success'))
        <div class="m-4 p-3 rounded-lg" style="background-color: #F0F9F4; border: 1px solid #42B574; color: #2D7A4F;">
            {{ session('success') }}
        </div>
    @endif
    @if(session()->has('error'))
        <div class="m-4 p-3 rounded-lg" style="background-color: #FEF2F2; border: 1px solid #EF4444; color: #991B1B;">
            {{ session('error') }}
        </div>
    @endif

    @if($orders->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr style="background-color: #F7F8F4;">
                        <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">#</th>
                        <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">Client</th>
                        <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">Cartes</th>
                        <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">Total</th>
                        <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">Statut</th>
                        <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">Date</th>
                        <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-t" style="border-color: #E5E7EB;">
                            <td class="px-4 py-3 text-sm font-mono font-semibold" style="color: #2C2A27;">#{{ $order->id }}</td>
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium" style="color: #2C2A27;">{{ $order->user->name ?? 'Supprimé' }}</p>
                                <p class="text-xs" style="color: #9CA3AF;">{{ $order->user->email ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3 text-sm font-medium" style="color: #2C2A27;">{{ $order->quantity }}</td>
                            <td class="px-4 py-3 text-sm font-semibold" style="color: #42B574;">{{ $order->amount_dollars }}$</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded-full font-medium text-white" style="background-color: {{ $order->statusColor }};">
                                    {{ $order->statusLabel }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-xs" style="color: #9CA3AF;">{{ $order->created_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">
                                <button wire:click="startEdit({{ $order->id }})" class="text-xs px-3 py-1 rounded-lg transition-colors" style="background-color: #F3F4F6; color: #4B5563;">
                                    Gérer
                                </button>
                                @if($order->status === 'pending')
                                    <button wire:click="deleteOrder({{ $order->id }})" wire:confirm="Supprimer la commande #{{ $order->id }} ?" class="text-xs px-2 py-1 rounded-lg ml-1" style="color: #EF4444;">
                                        ✕
                                    </button>
                                @endif
                            </td>
                        </tr>

                        {{-- Expanded detail row --}}
                        @if($editingOrderId === $order->id)
                            <tr style="background-color: #F7F8F4;">
                                <td colspan="7" class="px-4 py-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        {{-- Left: Items + URLs to program --}}
                                        <div>
                                            <p class="text-sm font-semibold mb-3" style="color: #2C2A27;">📋 Cartes à programmer</p>
                                            @if($order->items)
                                                @foreach($order->items as $item)
                                                    <div class="p-3 rounded-lg bg-white mb-2">
                                                        <div class="flex justify-between items-center mb-1">
                                                            <span class="text-sm font-medium" style="color: #2C2A27;">{{ $item['profile_name'] ?? 'Profil' }}</span>
                                                            <span class="text-xs px-2 py-0.5 rounded-full" style="background-color: #F3F4F6; color: #4B5563;">
                                                                {{ $item['quantity'] }} carte(s) · {{ ($item['design_type'] ?? 'standard') === 'custom' ? 'Custom' : 'Standard' }}
                                                            </span>
                                                        </div>
                                                        <div class="flex items-center space-x-2 mt-2">
                                                            <code class="text-xs px-2 py-1 rounded" style="background-color: #F0F9F4; color: #42B574; font-weight: 600;">
                                                                {{ $item['card_code'] ?? '—' }}
                                                            </code>
                                                            <span class="text-xs" style="color: #9CA3AF;">→</span>
                                                            <code class="text-xs px-2 py-1 rounded flex-1" style="background-color: #EFF6FF; color: #4A7FBF;" onclick="navigator.clipboard.writeText('https://app.linkcard.ca/c/{{ $item['card_code'] ?? '' }}'); this.innerText='Copié!'; setTimeout(() => this.innerText='https://app.linkcard.ca/c/{{ $item['card_code'] ?? '' }}', 1500)" title="Cliquez pour copier" role="button">
                                                                https://app.linkcard.ca/c/{{ $item['card_code'] ?? '' }}
                                                            </code>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p class="text-xs p-3 rounded-lg bg-white" style="color: #9CA3AF;">Ancienne commande — pas d'items détaillés.</p>
                                            @endif

                                            {{-- Adresse livraison --}}
                                            <div class="p-3 rounded-lg bg-white mt-3">
                                                <p class="text-xs font-medium mb-1" style="color: #4B5563;">📦 Adresse de livraison</p>
                                                @if($order->shipping_address)
                                                    <p class="text-sm" style="color: #2C2A27;">{{ $order->shipping_address['name'] ?? '' }}</p>
                                                    <p class="text-xs" style="color: #4B5563;">{{ $order->shipping_address['street'] ?? '' }}</p>
                                                    <p class="text-xs" style="color: #4B5563;">{{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['province'] ?? '' }} {{ $order->shipping_address['postal_code'] ?? '' }}</p>
                                                    <p class="text-xs" style="color: #4B5563;">{{ $order->shipping_address['phone'] ?? '' }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Right: Status + tracking --}}
                                        <div>
                                            <p class="text-sm font-semibold mb-3" style="color: #2C2A27;">⚙️ Gestion</p>
                                            <div class="p-3 rounded-lg bg-white">
                                                <label class="block text-xs font-medium mb-1" style="color: #4B5563;">Statut</label>
                                                <select wire:model="newStatus" class="w-full text-sm rounded-lg border px-3 py-2 mb-3" style="border-color: #D1D5DB;">
                                                    <option value="pending">En attente de paiement</option>
                                                    <option value="paid">Payée</option>
                                                    <option value="processing">En traitement</option>
                                                    <option value="shipped">Expédiée</option>
                                                    <option value="delivered">Livrée</option>
                                                </select>

                                                <label class="block text-xs font-medium mb-1" style="color: #4B5563;">Numéro de suivi</label>
                                                <input type="text" wire:model="trackingNumber" placeholder="Ex: CP123456789CA"
                                                       class="w-full text-sm rounded-lg border px-3 py-2" style="border-color: #D1D5DB;">
                                            </div>

                                            <div class="flex justify-end space-x-2 mt-4">
                                                <button wire:click="cancelEdit" class="px-4 py-2 text-sm rounded-lg" style="color: #4B5563; border: 1px solid #D1D5DB;">
                                                    Annuler
                                                </button>
                                                <button wire:click="updateOrderStatus({{ $order->id }})" class="px-4 py-2 text-sm rounded-lg text-white font-medium" style="background-color: #42B574;">
                                                    Sauvegarder
                                                </button>
                                            </div>
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
            <p class="text-sm" style="color: #9CA3AF;">Aucune commande pour le moment.</p>
        </div>
    @endif
</div>
