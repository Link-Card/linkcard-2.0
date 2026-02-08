<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show($username)
    {
        $profile = Profile::where('username', $username)
            ->with(['contentBands' => function($query) {
                $query->where('is_hidden', false)->orderBy('order');
            }])
            ->first();

        // Si pas trouvé, vérifier les redirections d'anciens usernames
        if (!$profile) {
            $redirect = \App\Models\UsernameRedirect::where('old_username', strtolower($username))
                ->where(function ($q) {
                    $q->whereNull('expires_at')        // permanent (code original)
                      ->orWhere('expires_at', '>', now()); // 90 jours (custom → custom)
                })
                ->with('profile')
                ->first();

            if ($redirect && $redirect->profile) {
                return redirect()->route('profile.public', $redirect->profile->username, 301);
            }

            abort(404);
        }

        // Incrémenter compteur vues
        $profile->increment('view_count');

        return view('profiles.show', compact('profile'));
    }

    public function downloadVcard(Profile $profile)
    {
        $vcard = "BEGIN:VCARD\n";
        $vcard .= "VERSION:3.0\n";
        $vcard .= "FN:" . $profile->full_name . "\n";
        $vcard .= "N:" . $profile->full_name . ";;;;\n";

        if($profile->job_title) {
            $vcard .= "TITLE:" . $profile->job_title . "\n";
        }

        if($profile->company) {
            $vcard .= "ORG:" . $profile->company . "\n";
        }

        if($profile->email) {
            $vcard .= "EMAIL:" . $profile->email . "\n";
        }

        if($profile->phone) {
            $vcard .= "TEL:" . $profile->phone . "\n";
        }

        if($profile->website) {
            $vcard .= "URL:" . $profile->website . "\n";
        }

        $profileUrl = url('/' . $profile->username);
        $vcard .= "URL;TYPE=WORK:" . $profileUrl . "\n";

        if($profile->photo_path) {
            $photoPath = storage_path('app/public/' . $profile->photo_path);
            if(file_exists($photoPath)) {
                $photoData = base64_encode(file_get_contents($photoPath));
                $photoType = pathinfo($photoPath, PATHINFO_EXTENSION);
                $mimeType = 'JPEG';
                if($photoType === 'png') $mimeType = 'PNG';
                if($photoType === 'gif') $mimeType = 'GIF';
                $vcard .= "PHOTO;ENCODING=b;TYPE=" . $mimeType . ":" . $photoData . "\n";
            }
        }

        $vcard .= "END:VCARD";

        return response($vcard)
            ->header('Content-Type', 'text/vcard; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="' . $profile->full_name . '.vcf"');
    }
}
