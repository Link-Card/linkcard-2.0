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
        'bio',
        'email',
        'phone',
        'website',
        'photo',
        'template_id',
        'header_color',
        'qr_code',
    ];

    /**
     * Relation: Un profil appartient à un utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation: Un profil a un template
     */
    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    /**
     * Relation: Un profil a plusieurs sections
     */
    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    /**
     * Relation: Un profil a plusieurs liens
     */
    public function links()
    {
        return $this->hasMany(Link::class);
    }

    /**
     * Relation: Un profil a plusieurs éléments de galerie
     */
    public function galleryItems()
    {
        return $this->hasMany(GalleryItem::class);
    }

    /**
     * Relation: Un profil a plusieurs analytics
     */
    public function analytics()
    {
        return $this->hasMany(Analytic::class);
    }
}
