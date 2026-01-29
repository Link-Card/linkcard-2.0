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
            ->with(['user', 'template'])
            ->firstOrFail();
        
        // Incrémenter le compteur de vues
        $profile->increment('view_count');
        
        return view('profiles.show', compact('profile'));
    }
}
