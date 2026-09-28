<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Identity;
use App\Models\Project;
use App\Models\Skill;

class DashboardController extends Controller
{
    public function index()
    {
        $identity = Identity::first();

        $stats = [
            'has_identity' => (bool) $identity,
            'has_photo' => (bool) $identity?->photo,
            'has_cv_creative' => (bool) $identity?->cv_creative_path,
            'has_cv_formal' => (bool) $identity?->cv_formal_path,
            'education_count' => Education::count(),
            'experience_count' => Experience::count(),
            'skill_count' => Skill::count(),
            'project_count' => Project::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
