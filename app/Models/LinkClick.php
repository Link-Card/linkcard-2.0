<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkClick extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'profile_id',
        'content_band_id',
        'platform',
        'url',
        'ip_hash',
        'clicked_at',
    ];

    protected $casts = [
        'clicked_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function contentBand()
    {
        return $this->belongsTo(ContentBand::class);
    }
}
