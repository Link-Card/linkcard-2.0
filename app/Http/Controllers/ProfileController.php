<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show($username)
    {
        $profile = Profile::where('username', $username)
            ->where('is_public', true)
            ->with(['links', 'galleryItems']) // Enlevé 'template' qui n'existe pas
            ->firstOrFail();

        // Incrémenter compteur vues
        $profile->incrementViewCount();

        return view('profiles.show', compact('profile'));
    }
}
