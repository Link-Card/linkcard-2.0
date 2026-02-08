<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Envoyer emails de bienvenue toutes les heures (24h après inscription)
Schedule::command('emails:send-welcome')->hourly();

// Archiver commandes livrées depuis +30 jours (1x par jour)
Schedule::command('orders:archive-delivered')->daily();

// Expirer les plan overrides et impersonation requests
Schedule::command('plans:expire-overrides')->hourly();
