<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'username',
        'full_name',
        'job_title',
        'company',
        'location',
        'bio',
        'email',
        'phone',
        'website',
        'photo_path',
        'template_id',
        'primary_color',
        'secondary_color',
        'background_type',
        'background_value',
        'is_public',
        'view_count',
        'qr_code',
        'meta_title',
        'meta_description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }

    public function galleryItems()
    {
        return $this->hasMany(GalleryItem::class);
    }

    public function analytics()
    {
        return $this->hasMany(Analytic::class);
    }
}
