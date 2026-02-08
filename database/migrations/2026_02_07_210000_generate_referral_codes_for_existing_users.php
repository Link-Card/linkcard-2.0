<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\User;

return new class extends Migration
{
    public function up(): void
    {
        $chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';

        User::whereNull('referral_code')->each(function ($user) use ($chars) {
            // Essayer d'utiliser le username du premier profil
            $profile = $user->profiles()->first();
            if ($profile && $profile->username) {
                $code = strtoupper($profile->username);
                if (!User::where('referral_code', $code)->exists()) {
                    $user->update(['referral_code' => $code]);
                    return;
                }
            }

            // Sinon code aléatoire 8 chars
            do {
                $code = '';
                for ($i = 0; $i < 8; $i++) {
                    $code .= $chars[random_int(0, strlen($chars) - 1)];
                }
            } while (User::where('referral_code', $code)->exists());

            $user->update(['referral_code' => $code]);
        });
    }

    public function down(): void
    {
        User::whereNotNull('referral_code')->update(['referral_code' => null]);
    }
};
