<?php

namespace App\Console\Commands;

use App\Mail\Welcome;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmails extends Command
{
    protected $signature = 'emails:send-welcome';
    protected $description = 'Envoie les emails de bienvenue 24h après inscription';

    public function handle()
    {
        $users = User::whereNull('welcome_email_sent_at')
            ->whereNotNull('email_verified_at')
            ->where('created_at', '<=', now()->subHours(24))
            ->get();

        $count = 0;

        foreach ($users as $user) {
            try {
                Mail::to($user->email)->send(new Welcome($user));
                $user->update(['welcome_email_sent_at' => now()]);
                $count++;
            } catch (\Exception $e) {
                Log::error('Welcome email failed', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $this->info("Envoyé {$count} email(s) de bienvenue.");
        return Command::SUCCESS;
    }
}
