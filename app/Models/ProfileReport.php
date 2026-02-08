<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileReport extends Model
{
    protected $fillable = [
        'profile_id',
        'reporter_id',
        'reason',
        'details',
        'status',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function getReasonLabelAttribute(): string
    {
        return match($this->reason) {
            'explicit_content' => 'Contenu explicite / sexuel',
            'illegal_content' => 'Contenu illégal',
            'harassment' => 'Harcèlement / menaces',
            'spam' => 'Spam / arnaque',
            'impersonation' => 'Usurpation d\'identité',
            'hate_speech' => 'Discours haineux',
            'dangerous_links' => 'Liens dangereux / malveillants',
            'other' => 'Autre',
            default => $this->reason,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'En attente',
            'reviewed' => 'Examiné',
            'actioned' => 'Action prise',
            'dismissed' => 'Rejeté',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => '#F59E0B',
            'reviewed' => '#4A7FBF',
            'actioned' => '#EF4444',
            'dismissed' => '#9CA3AF',
            default => '#9CA3AF',
        };
    }
}
