<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
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
                            @php
                                $planColors = [
                                    'free' => ['bg' => '#F3F4F6', 'text' => '#4B5563'],
                                    'pro' => ['bg' => '#EFF6FF', 'text' => '#4A7FBF'],
                                    'premium' => ['bg' => '#F0F9F4', 'text' => '#42B574'],
                                ];
                                $c = $planColors[$user->plan] ?? $planColors['free'];
                            @endphp
                            <span class="px-2 py-1 text-xs rounded-full font-medium" style="background-color: {{ $c['bg'] }}; color: {{ $c['text'] }};">
                                {{ strtoupper($user->plan ?? 'free') }}
                            </span>
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
