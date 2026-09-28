<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'media_path',
        'media_type',
        'external_url',
        'tags',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function getMediaUrlAttribute(): ?string
    {
        return $this->media_path ? Storage::disk('public')->url($this->media_path) : null;
    }

    /**
     * Tags as a clean array, e.g. "SQL, Power BI" -> ['SQL', 'Power BI']
     */
    public function getTagListAttribute(): array
    {
        if (! $this->tags) {
            return [];
        }

        return array_filter(array_map('trim', explode(',', $this->tags)));
    }
}
