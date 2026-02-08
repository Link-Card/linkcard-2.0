<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsernameRedirect extends Model
{
    protected $fillable = ['old_username', 'profile_id'];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
