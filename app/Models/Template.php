<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\TemplateService;

class Template extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'category', 'config',
        'type', 'is_active', 'is_featured', 'required_plans',
        'usage_count', 'author',
    ];

    protected $casts = [
        'config' => 'array',
        'required_plans' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Get template config from TemplateService (source of truth).
     */
    public function getTemplateConfig(): ?array
    {
        return TemplateService::get($this->slug);
    }
}
