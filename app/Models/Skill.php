<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'proficiency',
        'icon',
        'sort_order',
    ];

    protected $casts = [
        'proficiency' => 'integer',
        'sort_order' => 'integer',
    ];

    public const CATEGORIES = ['Frontend', 'Backend', 'Database', 'Tools', 'Other'];
}
