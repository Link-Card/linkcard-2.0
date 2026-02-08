<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    @if(session()->has('success'))
        <div class="m-4 p-3 rounded-lg" style="background-color: #F0F9F4; border: 1px solid #42B574; color: #2D7A4F;">
            {{ session('success') }}
        </div>
    @endif

    @include('livewire.admin.partials.delete-modal')

    @if($orders->count() > 0)
        {{-- Mobile: Cards --}}
        <div class="md:hidden divide-y" style="border-color: #E5E7EB;">
            @foreach($orders as $order)
                <div class="p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-mono font-semibold" style="color: #2C2A27;">{{ $order->order_number ?? '#'.$order->id }}</span>
                        <span class="px-2 py-1 text-xs rounded-full font-medium text-white" style="background-color: {{ $order->statusColor }};">
                            {{ $order->statusLabel }}
                        </span>
                    </div>
                    <p class="text-sm font-medium" style="color: #2C2A27;">{{ $order->user->name ?? 'Supprimé' }}</p>
                    <p class="text-xs mb-2" style="color: #9CA3AF;">{{ $order->user->email ?? '-' }}</p>
                    <div class="flex items-center space-x-4 text-xs mb-3" style="color: #4B5563;">
                        <span>{{ $order->quantity }} carte(s)</span>
                        <span class="font-semibold" style="color: #42B574;">{{ $order->amount_dollars }}$</span>
                        <span style="color: #9CA3AF;">{{ $order->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @if($order->status === 'delivered')
                            <span class="px-3 py-1.5 text-xs rounded-xl font-medium" style="background-color: #F0F9F4; color: #42B574;">✓ Terminée</span>
                            <button wire:click="archiveOrder({{ $order->id }})" class="px-3 py-1.5 text-xs rounded-xl font-medium" style="background-color: #F3F4F6; color: #4B5563; border: 1.5px solid #9CA3AF;">Archiver</button>
                            <button wire:click="confirmDelete({{ $order->id }})" class="px-3 py-1.5 text-xs rounded-xl font-medium" style="background-color: #FEF2F2; color: #EF4444; border: 1.5px solid #EF4444;">Supprimer</button>
                        @else
                            <button wire:click="startEdit({{ $order->id }})" class="px-3 py-1.5 text-xs rounded-xl font-medium" style="background-color: #F0F9F4; color: #42B574; border: 1.5px solid #42B574;">Gérer</button>
                            @if($order->status === 'shipped')
                                <button wire:click="archiveOrder({{ $order->id }})" class="px-3 py-1.5 text-xs rounded-xl font-medium" style="background-color: #F3F4F6; color: #4B5563; border: 1.5px solid #9CA3AF;">Archiver</button>
                            @endif
                            <button wire:click="confirmDelete({{ $order->id }})" class="px-3 py-1.5 text-xs rounded-xl font-medium" style="background-color: #FEF2F2; color: #EF4444; border: 1.5px solid #EF4444;">Supprimer</button>
                        @endif
                    </div>

                    {{-- Expanded detail mobile --}}
                    @if($editingOrderId === $order->id)
                        <div class="mt-4 pt-4 space-y-3" style="border-top: 1px solid #E5E7EB;">
                            {{-- Items --}}
                            @if($order->items)
                                <p class="text-sm font-semibold" style="color: #2C2A27;">📋 Cartes à programmer</p>
                                @foreach($order->items as $item)
                                    <div class="p-3 rounded-xl bg-white shadow-sm" style="background-color: #F7F8F4;">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-sm font-semibold" style="color: #2C2A27;">
                                                {{ $item['profile_name'] ?? 'Profil' }}
                                                @if(($item['order_type'] ?? 'new') === 'replacement')
                                                    <span class="text-xs px-2 py-0.5 rounded-full ml-1" style="background-color: #FEF3C7; color: #92400E;">🔄</span>
                                                @endif
                                            </span>
                                            <span class="text-xs px-2 py-0.5 rounded-full font-medium" style="background-color: {{ ($item['design_type'] ?? 'standard') === 'custom' ? '#EFF6FF' : '#F3F4F6' }}; color: {{ ($item['design_type'] ?? 'standard') === 'custom' ? '#4A7FBF' : '#4B5563' }};">
                                                {{ $item['quantity'] ?? 1 }}x · {{ ($item['design_type'] ?? 'standard') === 'custom' ? 'Custom' : 'Std' }}
                                            </span>
                                        </div>
                                        @php $codes = $item['card_codes'] ?? (isset($item['card_code']) ? [$item['card_code']] : []); @endphp
                                        @foreach($codes as $code)
                                            <div class="flex items-center space-x-2 mt-1 p-2 rounded-lg" style="background-color: #EFF6FF;">
                                                <span class="text-xs font-semibold" style="color: #4A7FBF;">NFC →</span>
                                                <code class="text-xs font-mono break-all cursor-pointer" style="color: #4A7FBF;"
                                                      onclick="navigator.clipboard.writeText('https://app.linkcard.ca/c/{{ $code }}'); let el=this; el.dataset.orig=el.innerText; el.innerText='✅ Copié!'; setTimeout(()=>el.innerText=el.dataset.orig, 1500)">
                                                    https://app.linkcard.ca/c/{{ $code }}
                                                </code>
                                            </div>
                                            <div class="flex items-center space-x-2 mt-1">
                                                <span class="text-xs" style="color: #9CA3AF;">Code:</span>
                                                <code class="text-sm font-bold font-mono px-2 py-0.5 rounded" style="color: #2C2A27; background-color: #F3F4F6;">{{ $code }}</code>
                                            </div>
                                        @endforeach
                                        @if(isset($item['profile_url']) && $item['profile_url'])
                                            <div class="flex items-center space-x-2 mt-1">
                                                <span class="text-xs" style="color: #9CA3AF;">Profil →</span>
                                                <a href="{{ $item['profile_url'] }}" target="_blank" class="text-xs underline" style="color: #42B574;">{{ $item['profile_url'] }}</a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @endif

                            {{-- Logo --}}
                            @if($order->logo_path)
                                <div class="p-3 rounded-xl shadow-sm" style="background-color: #F7F8F4;">
                                    <div class="flex justify-between items-center mb-2">
                                        <p class="text-sm font-medium" style="color: #2C2A27;">🎨 Logo</p>
                                        <a href="{{ asset('storage/' . $order->logo_path) }}" download="logo-commande-{{ $order->id }}.png"
                                           class="px-3 py-1.5 text-xs rounded-xl font-medium"
                                           style="background-color: #F0F9F4; color: #42B574; border: 1.5px solid #42B574;">⬇</a>
                                    </div>
                                    <div class="rounded-xl overflow-hidden inline-block p-2" style="background: repeating-conic-gradient(#f3f4f6 0% 25%, #fff 0% 50%) 50% / 14px 14px;">
                                        <img src="{{ asset('storage/' . $order->logo_path) }}" class="h-20 object-contain">
                                    </div>
                                </div>
                            @endif

                            {{-- Adresse --}}
                            @if($order->shipping_address)
                                <div class="p-3 rounded-xl shadow-sm" style="background-color: #F7F8F4;">
                                    <p class="text-sm font-medium mb-1" style="color: #2C2A27;">📦 Adresse</p>
                                    <p class="text-sm font-medium" style="color: #2C2A27;">{{ $order->shipping_address['name'] ?? '' }}</p>
                                    <p class="text-xs" style="color: #4B5563;">{{ $order->shipping_address['street'] ?? '' }}</p>
                                    <p class="text-xs" style="color: #4B5563;">{{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['province'] ?? '' }} {{ $order->shipping_address['postal_code'] ?? '' }}</p>
                                    <p class="text-xs mt-1" style="color: #4B5563;">📞 {{ $order->shipping_address['phone'] ?? '' }}</p>
                                </div>
                            @endif

                            {{-- Gestion --}}
                            <div class="p-3 rounded-xl shadow-sm" style="background-color: #F7F8F4;">
                                <p class="text-sm font-semibold mb-2" style="color: #2C2A27;">⚙️ Gestion</p>
                                <label class="block text-xs font-medium mb-1" style="color: #4B5563;">Statut</label>
                                <select wire:model="newStatus" class="w-full text-sm rounded-xl border px-3 py-2.5 mb-3" style="border-color: #D1D5DB;">
                                    <option value="paid">Payée</option>
                                    <option value="processing">En traitement</option>
                                    <option value="shipped">Expédiée</option>
                                    <option value="delivered">Livrée</option>
                                </select>
                                <label class="block text-xs font-medium mb-1" style="color: #4B5563;">Numéro de suivi</label>
                                <input type="text" wire:model="trackingNumber" placeholder="Ex: CP123456789CA"
                                       class="w-full text-sm rounded-xl border px-3 py-2.5" style="border-color: #D1D5DB;">
                            </div>
                            <div class="flex space-x-3">
                                <button wire:click="cancelEdit" class="flex-1 px-4 py-2.5 text-sm rounded-xl font-medium" style="color: #4B5563; border: 1.5px solid #D1D5DB;">Annuler</button>
                                <button wire:click="updateOrderStatus({{ $order->id }})" wire:loading.attr="disabled" class="flex-1 px-4 py-2.5 text-sm rounded-xl text-white font-medium disabled:opacity-60" style="background-color: #42B574;">
                                    <span wire:loading.remove wire:target="updateOrderStatus({{ $order->id }})">Sauvegarder</span>
                                    <span wire:loading wire:target="updateOrderStatus({{ $order->id }})">Envoi...</span>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Desktop: Table --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr style="background-color: #F7F8F4;">
                        <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">#</th>
                        <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">Client</th>
                        <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">Cartes</th>
                        <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">Total</th>
                        <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">Statut</th>
                        <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">Date</th>
                        <th class="text-right px-4 py-3 text-xs font-medium" style="color: #4B5563;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-t" style="border-color: #E5E7EB;">
                            <td class="px-4 py-3 text-sm font-mono font-semibold" style="color: #2C2A27;">{{ $order->order_number ?? '#'.$order->id }}</td>
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
                                <div class="flex items-center justify-end space-x-2">
                                    @if($order->status === 'delivered')
                                        <span class="px-4 py-2 text-xs rounded-xl font-medium" style="background-color: #F0F9F4; color: #42B574;">
                                            ✓ Terminée
                                        </span>
                                        <button wire:click="archiveOrder({{ $order->id }})"
                                                class="px-4 py-2 text-xs rounded-xl font-medium transition-all"
                                                style="background-color: #F3F4F6; color: #4B5563; border: 1.5px solid #9CA3AF;">
                                            Archiver
                                        </button>
                                        <button wire:click="confirmDelete({{ $order->id }})"
                                                class="px-4 py-2 text-xs rounded-xl font-medium transition-all"
                                                style="background-color: #FEF2F2; color: #EF4444; border: 1.5px solid #EF4444;">
                                            Supprimer
                                        </button>
                                    @else
                                        <button wire:click="startEdit({{ $order->id }})"
                                                class="px-4 py-2 text-xs rounded-xl font-medium transition-all"
                                                style="background-color: #F0F9F4; color: #42B574; border: 1.5px solid #42B574;">
                                            Gérer
                                        </button>
                                        @if($order->status === 'shipped')
                                            <button wire:click="archiveOrder({{ $order->id }})"
                                                    class="px-4 py-2 text-xs rounded-xl font-medium transition-all"
                                                    style="background-color: #F3F4F6; color: #4B5563; border: 1.5px solid #9CA3AF;">
                                                Archiver
                                            </button>
                                        @endif
                                        <button wire:click="confirmDelete({{ $order->id }})"
                                                class="px-4 py-2 text-xs rounded-xl font-medium transition-all"
                                                style="background-color: #FEF2F2; color: #EF4444; border: 1.5px solid #EF4444;">
                                            Supprimer
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- Expanded detail --}}
                        @if($editingOrderId === $order->id)
                            <tr style="background-color: #F7F8F4;">
                                <td colspan="7" class="px-4 py-5">
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                                        {{-- Left: Items + URLs --}}
                                        <div>
                                            <p class="text-sm font-semibold mb-3" style="color: #2C2A27;">📋 Cartes à programmer</p>
                                            @if($order->items)
                                                @foreach($order->items as $item)
                                                    <div class="p-4 rounded-xl bg-white mb-3 shadow-sm">
                                                        <div class="flex justify-between items-center mb-2">
                                                            <span class="text-sm font-semibold" style="color: #2C2A27;">
                                                                {{ $item['profile_name'] ?? 'Profil' }}
                                                                @if(($item['order_type'] ?? 'new') === 'replacement')
                                                                    <span class="text-xs px-2 py-0.5 rounded-full ml-1" style="background-color: #FEF3C7; color: #92400E;">🔄 Remplacement</span>
                                                                @endif
                                                            </span>
                                                            <span class="text-xs px-2.5 py-1 rounded-full font-medium" style="background-color: {{ ($item['design_type'] ?? 'standard') === 'custom' ? '#EFF6FF' : '#F3F4F6' }}; color: {{ ($item['design_type'] ?? 'standard') === 'custom' ? '#4A7FBF' : '#4B5563' }};">
                                                                {{ $item['quantity'] ?? 1 }} carte(s) · {{ ($item['design_type'] ?? 'standard') === 'custom' ? 'Custom' : 'Standard' }}
                                                            </span>
                                                        </div>

                                                        @php $codes = $item['card_codes'] ?? (isset($item['card_code']) ? [$item['card_code']] : []); @endphp
                                                        @foreach($codes as $code)
                                                            {{-- NFC URL --}}
                                                            <div class="flex items-center space-x-2 mt-2 p-2 rounded-lg" style="background-color: #EFF6FF;">
                                                                <span class="text-xs font-semibold whitespace-nowrap" style="color: #4A7FBF;">NFC →</span>
                                                                <code class="text-xs flex-1 cursor-pointer font-mono" style="color: #4A7FBF;"
                                                                      onclick="navigator.clipboard.writeText('https://app.linkcard.ca/c/{{ $code }}'); let el=this; el.dataset.orig=el.innerText; el.innerText='✅ Copié!'; setTimeout(()=>el.innerText=el.dataset.orig, 1500)" title="Cliquer pour copier">
                                                                    https://app.linkcard.ca/c/{{ $code }}
                                                                </code>
                                                            </div>

                                                            {{-- Card code --}}
                                                            <div class="flex items-center space-x-2 mt-2">
                                                                <span class="text-xs" style="color: #9CA3AF;">Code carte imprimé:</span>
                                                                <code class="text-sm font-bold font-mono px-2 py-0.5 rounded" style="color: #2C2A27; background-color: #F3F4F6;">{{ $code }}</code>
                                                            </div>
                                                        @endforeach

                                                        @if(isset($item['profile_url']) && $item['profile_url'])
                                                            <div class="flex items-center space-x-2 mt-1">
                                                                <span class="text-xs" style="color: #9CA3AF;">Profil →</span>
                                                                <a href="{{ $item['profile_url'] }}" target="_blank" class="text-xs underline" style="color: #42B574;">{{ $item['profile_url'] }}</a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @else
                                                <p class="text-xs p-3 rounded-lg bg-white" style="color: #9CA3AF;">Ancienne commande — pas d'items détaillés.</p>
                                            @endif

                                            {{-- Logo downloadable --}}
                                            @if($order->logo_path)
                                                <div class="p-4 rounded-xl bg-white mt-3 shadow-sm">
                                                    <div class="flex justify-between items-center mb-3">
                                                        <p class="text-sm font-medium" style="color: #2C2A27;">🎨 Logo personnalisé</p>
                                                        <a href="{{ asset('storage/' . $order->logo_path) }}" download="logo-commande-{{ $order->id }}.png"
                                                           class="px-4 py-2 text-xs rounded-xl font-medium transition-all"
                                                           style="background-color: #F0F9F4; color: #42B574; border: 1.5px solid #42B574;">
                                                            ⬇ Télécharger PNG
                                                        </a>
                                                    </div>
                                                    <div class="rounded-xl overflow-hidden inline-block p-2" style="background: repeating-conic-gradient(#f3f4f6 0% 25%, #fff 0% 50%) 50% / 14px 14px;">
                                                        <img src="{{ asset('storage/' . $order->logo_path) }}" class="h-24 object-contain">
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- Adresse --}}
                                            <div class="p-4 rounded-xl bg-white mt-3 shadow-sm">
                                                <p class="text-sm font-medium mb-2" style="color: #2C2A27;">📦 Adresse de livraison</p>
                                                @if($order->shipping_address)
                                                    <p class="text-sm font-medium" style="color: #2C2A27;">{{ $order->shipping_address['name'] ?? '' }}</p>
                                                    <p class="text-sm" style="color: #4B5563;">{{ $order->shipping_address['street'] ?? '' }}</p>
                                                    <p class="text-sm" style="color: #4B5563;">{{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['province'] ?? '' }} {{ $order->shipping_address['postal_code'] ?? '' }}</p>
                                                    <p class="text-sm mt-1" style="color: #4B5563;">📞 {{ $order->shipping_address['phone'] ?? '' }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Right: Status + tracking --}}
                                        <div>
                                            <p class="text-sm font-semibold mb-3" style="color: #2C2A27;">⚙️ Gestion</p>
                                            <div class="p-4 rounded-xl bg-white shadow-sm">
                                                <label class="block text-xs font-medium mb-1" style="color: #4B5563;">Statut</label>
                                                {{-- TODO POST-BETA: Verrouiller le flow des statuts pour empêcher de revenir en arrière
                                                     (ex: delivered → processing interdit). Garder flexible pendant les tests. --}}
                                                <select wire:model="newStatus" class="w-full text-sm rounded-xl border px-3 py-2.5 mb-4" style="border-color: #D1D5DB;">
                                                    <option value="paid">Payée</option>
                                                    <option value="processing">En traitement</option>
                                                    <option value="shipped">Expédiée</option>
                                                    <option value="delivered">Livrée</option>
                                                </select>

                                                <label class="block text-xs font-medium mb-1" style="color: #4B5563;">Numéro de suivi</label>
                                                <input type="text" wire:model="trackingNumber" placeholder="Ex: CP123456789CA"
                                                       class="w-full text-sm rounded-xl border px-3 py-2.5" style="border-color: #D1D5DB;">
                                            </div>

                                            <div class="flex space-x-3 mt-4">
                                                <button wire:click="cancelEdit" class="flex-1 px-5 py-3 text-sm rounded-xl font-medium transition-colors" style="color: #4B5563; border: 1.5px solid #D1D5DB;">
                                                    Annuler
                                                </button>
                                                <button wire:click="updateOrderStatus({{ $order->id }})" wire:loading.attr="disabled" class="flex-1 px-5 py-3 text-sm rounded-xl text-white font-medium transition-colors disabled:opacity-60" style="background-color: #42B574;">
                                                    <span wire:loading.remove wire:target="updateOrderStatus({{ $order->id }})">Sauvegarder</span>
                                                    <span wire:loading wire:target="updateOrderStatus({{ $order->id }})" class="flex items-center justify-center">
                                                        <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                                        Envoi...
                                                    </span>
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
            <svg class="w-12 h-12 mx-auto mb-3" style="color: #D1D5DB;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-sm" style="color: #9CA3AF;">Aucune commande active.</p>
        </div>
    @endif
</div>
