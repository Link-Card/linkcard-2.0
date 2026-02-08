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

    {{-- Delete User Modal --}}
    @if($deletingUserId)
        @php $deletingUser = $users->firstWhere('id', $deletingUserId); @endphp
        @if($deletingUser)
            <div class="fixed inset-0 z-50 flex items-center justify-center" style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);">
                <div class="bg-white rounded-2xl shadow-xl max-w-md w-full mx-4 p-6" style="animation: popupIn 0.2s ease-out;">
                    {{-- Header --}}
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: #FEF2F2;">
                            <svg class="w-5 h-5" style="color: #EF4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold" style="color: #2C2A27;">Supprimer l'utilisateur</h3>
                            <p class="text-sm" style="color: #9CA3AF;">Cette action est irréversible</p>
                        </div>
                    </div>

                    {{-- User info --}}
                    <div class="rounded-xl p-4 mb-4" style="background-color: #F3F4F6;">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-semibold text-white" style="background-color: #42B574;">
                                {{ strtoupper(substr($deletingUser->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium" style="color: #2C2A27;">{{ $deletingUser->name }}</p>
                                <p class="text-xs" style="color: #9CA3AF;">{{ $deletingUser->email }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-2 text-center">
                            <div class="rounded-lg p-2" style="background-color: white;">
                                <p class="text-lg font-semibold" style="color: #2C2A27;">{{ $deletingUser->profiles_count }}</p>
                                <p class="text-xs" style="color: #9CA3AF;">Profils</p>
                            </div>
                            <div class="rounded-lg p-2" style="background-color: white;">
                                <p class="text-lg font-semibold" style="color: #2C2A27;">{{ $deletingUser->cards_count }}</p>
                                <p class="text-xs" style="color: #9CA3AF;">Cartes</p>
                            </div>
                            <div class="rounded-lg p-2" style="background-color: white;">
                                <p class="text-lg font-semibold" style="color: #2C2A27;">{{ $deletingUser->card_orders_count }}</p>
                                <p class="text-xs" style="color: #9CA3AF;">Commandes</p>
                            </div>
                        </div>
                        <p class="text-xs mt-3" style="color: #EF4444;">
                            Tout sera supprimé : profils, bandes de contenu, cartes, commandes, images.
                        </p>
                    </div>

                    {{-- Reason --}}
                    <div class="mb-3">
                        <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="color: #4B5563;">Raison *</label>
                        <select wire:model.live="deleteUserReason" class="w-full text-sm rounded-xl border px-3 py-2.5" style="border-color: #D1D5DB;">
                            <option value="">Sélectionner...</option>
                            <option value="test_account">Compte de test</option>
                            <option value="duplicate">Compte dupliqué</option>
                            <option value="spam">Spam / Faux compte</option>
                            <option value="user_request">Demande de l'utilisateur</option>
                            <option value="inactive">Compte inactif</option>
                            <option value="other">Autre</option>
                        </select>
                    </div>

                    {{-- Note --}}
                    <div class="mb-4">
                        <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="color: #4B5563;">Note (optionnel)</label>
                        <textarea wire:model="deleteUserNote" rows="2" class="w-full text-sm rounded-xl border px-3 py-2.5" style="border-color: #D1D5DB;" placeholder="Détails supplémentaires..."></textarea>
                    </div>

                    {{-- Password confirmation --}}
                    <div class="mb-4">
                        <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="color: #EF4444;">Mot de passe admin *</label>
                        <input wire:model="deleteUserPassword" type="password" class="w-full text-sm rounded-xl border px-3 py-2.5" style="border-color: #D1D5DB;" placeholder="Entrez votre mot de passe pour confirmer" autocomplete="off">
                    </div>

                    @if($deleteUserError)
                        <div class="mb-4 p-3 rounded-lg text-sm" style="background-color: #FEF2F2; border: 1px solid #EF4444; color: #991B1B;">
                            {{ $deleteUserError }}
                        </div>
                    @endif

                    {{-- Actions --}}
                    <div class="flex space-x-3">
                        <button wire:click="cancelDeleteUser" class="flex-1 px-5 py-3 text-sm rounded-xl font-medium transition-colors" style="color: #4B5563; border: 1.5px solid #D1D5DB;">
                            Annuler
                        </button>
                        <button wire:click="deleteUser" wire:loading.attr="disabled" class="flex-1 px-5 py-3 text-sm rounded-xl text-white font-medium transition-colors disabled:opacity-60" style="background-color: #EF4444;">
                            <span wire:loading.remove wire:target="deleteUser">Supprimer définitivement</span>
                            <span wire:loading wire:target="deleteUser" class="flex items-center justify-center">
                                <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                Suppression...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        @endif
    @endif

    {{-- Mobile: Cards --}}
    <div class="md:hidden divide-y" style="border-color: #E5E7EB;">
        @foreach($users as $user)
            <div class="p-4">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-semibold text-white" style="background-color: #42B574;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium" style="color: #2C2A27;">{{ $user->name }}</p>
                            <p class="text-xs" style="color: #9CA3AF;">{{ $user->email }}</p>
                        </div>
                    </div>
                    @if($user->role !== 'super_admin' && $user->role !== 'admin')
                        <div class="flex items-center space-x-1">
                            <button wire:click="impersonate({{ $user->id }})" class="p-2 rounded-lg" style="color: #4A7FBF;" title="Voir en tant que">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                            <button wire:click="confirmDeleteUser({{ $user->id }})" class="p-2 rounded-lg" style="color: #EF4444;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>
                <div class="flex flex-wrap items-center gap-2 mt-2">
                    @if($changingPlanUserId === $user->id)
                        <div class="flex items-center space-x-1">
                            <select wire:model="newPlan" class="text-xs rounded-lg border px-2 py-1" style="border-color: #D1D5DB;">
                                <option value="free">FREE</option>
                                <option value="pro">PRO</option>
                                <option value="premium">PREMIUM</option>
                            </select>
                            <button wire:click="changePlan" class="p-1 rounded" style="color: #42B574;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </button>
                            <button wire:click="cancelChangePlan" class="p-1 rounded" style="color: #EF4444;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    @else
                        @php
                            $planColors = [
                                'free' => ['bg' => '#F3F4F6', 'text' => '#4B5563'],
                                'pro' => ['bg' => '#EFF6FF', 'text' => '#4A7FBF'],
                                'premium' => ['bg' => '#F0F9F4', 'text' => '#42B574'],
                            ];
                            $c = $planColors[$user->plan] ?? $planColors['free'];
                        @endphp
                        <button wire:click="startChangePlan({{ $user->id }}, '{{ $user->plan }}')"
                                class="px-2 py-0.5 text-xs rounded-full font-medium"
                                style="background-color: {{ $c['bg'] }}; color: {{ $c['text'] }};">
                            {{ strtoupper($user->plan ?? 'free') }}
                            <svg class="w-2.5 h-2.5 inline ml-0.5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                    @endif
                    @if($user->role === 'super_admin')
                        <span class="px-2 py-0.5 text-xs rounded-full font-medium text-white" style="background-color: #EF4444;">Super Admin</span>
                    @elseif($user->role === 'admin')
                        <span class="px-2 py-0.5 text-xs rounded-full font-medium text-white" style="background-color: #F59E0B;">Admin</span>
                    @endif
                    <span class="text-xs" style="color: #9CA3AF;">{{ $user->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="flex items-center space-x-4 mt-2 text-xs" style="color: #4B5563;">
                    <span>{{ $user->profiles_count }} profil(s)</span>
                    <span>{{ $user->cards_count }} carte(s)</span>
                    <span>{{ $user->card_orders_count }} cmd</span>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Desktop: Table --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr style="background-color: #F7F8F4;">
                    <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">ID</th>
                    <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">Nom</th>
                    <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">Email</th>
                    <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">Plan</th>
                    <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">Rôle</th>
                    <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">Profils</th>
                    <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">Cartes</th>
                    <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">Commandes</th>
                    <th class="text-left px-4 py-3 text-xs font-medium" style="color: #4B5563;">Inscrit le</th>
                    <th class="text-right px-4 py-3 text-xs font-medium" style="color: #4B5563;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr class="border-t" style="border-color: #E5E7EB;">
                        <td class="px-4 py-3 text-sm font-mono" style="color: #9CA3AF;">{{ $user->id }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-semibold text-white" style="background-color: #42B574;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="text-sm font-medium" style="color: #2C2A27;">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm" style="color: #4B5563;">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            @if($changingPlanUserId === $user->id)
                                {{-- Inline plan change --}}
                                <div class="flex items-center space-x-1">
                                    <select wire:model="newPlan" class="text-xs rounded-lg border px-2 py-1" style="border-color: #D1D5DB;">
                                        <option value="free">FREE</option>
                                        <option value="pro">PRO</option>
                                        <option value="premium">PREMIUM</option>
                                    </select>
                                    <button wire:click="changePlan" class="p-1 rounded" style="color: #42B574;" title="Confirmer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                    <button wire:click="cancelChangePlan" class="p-1 rounded" style="color: #EF4444;" title="Annuler">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            @else
                                @php
                                    $planColors = [
                                        'free' => ['bg' => '#F3F4F6', 'text' => '#4B5563'],
                                        'pro' => ['bg' => '#EFF6FF', 'text' => '#4A7FBF'],
                                        'premium' => ['bg' => '#F0F9F4', 'text' => '#42B574'],
                                    ];
                                    $c = $planColors[$user->plan] ?? $planColors['free'];
                                @endphp
                                <button wire:click="startChangePlan({{ $user->id }}, '{{ $user->plan }}')"
                                        class="px-2 py-1 text-xs rounded-full font-medium cursor-pointer transition-opacity hover:opacity-80"
                                        style="background-color: {{ $c['bg'] }}; color: {{ $c['text'] }};"
                                        title="Cliquer pour changer le plan">
                                    {{ strtoupper($user->plan ?? 'free') }}
                                    <svg class="w-2.5 h-2.5 inline ml-0.5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($user->role === 'super_admin')
                                <span class="px-2 py-1 text-xs rounded-full font-medium text-white" style="background-color: #EF4444;">Super Admin</span>
                            @elseif($user->role === 'admin')
                                <span class="px-2 py-1 text-xs rounded-full font-medium text-white" style="background-color: #F59E0B;">Admin</span>
                            @else
                                <span class="text-xs" style="color: #9CA3AF;">User</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-center" style="color: #2C2A27;">{{ $user->profiles_count }}</td>
                        <td class="px-4 py-3 text-sm text-center" style="color: #2C2A27;">{{ $user->cards_count }}</td>
                        <td class="px-4 py-3 text-sm text-center" style="color: #2C2A27;">{{ $user->card_orders_count }}</td>
                        <td class="px-4 py-3 text-xs" style="color: #9CA3AF;">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-right">
                            @if($user->role !== 'super_admin' && $user->role !== 'admin')
                                <div class="flex items-center justify-end space-x-1">
                                    <button wire:click="impersonate({{ $user->id }})" class="p-2 rounded-lg transition-colors" style="color: #4A7FBF;" title="Se connecter en tant que" onmouseover="this.style.backgroundColor='#EFF6FF'" onmouseout="this.style.backgroundColor='transparent'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    <button wire:click="confirmDeleteUser({{ $user->id }})" class="p-2 rounded-lg transition-colors" style="color: #EF4444;" title="Supprimer" onmouseover="this.style.backgroundColor='#FEF2F2'" onmouseout="this.style.backgroundColor='transparent'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            @else
                                <span class="text-xs" style="color: #D1D5DB;">—</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    @keyframes popupIn {
        from { opacity: 0; transform: scale(0.95) translateY(10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
</style>
