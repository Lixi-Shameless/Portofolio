<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Identity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'headline',
        'bio',
        'email',
        'phone',
        'address',
        'photo',
        'cv_creative_path',
        'cv_formal_path',
        'linkedin_url',
        'github_url',
        'twitter_url',
        'website_url',
    ];

    /**
     * Full public URL to the profile photo (or null).
     */
    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? Storage::disk('public')->url($this->photo) : null;
    }
}
