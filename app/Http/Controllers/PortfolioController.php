<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Identity;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    public function index()
    {
        $identity = Identity::first();

        $educations = Education::orderByDesc('start_date')->get();

        $experiences = Experience::orderByDesc('is_current')
            ->orderByDesc('start_date')
            ->get();

        $skills = Skill::orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->groupBy('category');

        $projects = Project::orderBy('sort_order')
            ->orderByDesc('created_at')
            ->get();

        return view('portfolio.index', compact(
            'identity',
            'educations',
            'experiences',
            'skills',
            'projects'
        ));
    }

    /**
     * Public CV download: /cv/creative or /cv/formal
     */
    public function downloadCv(string $type)
    {
        abort_unless(in_array($type, ['creative', 'formal'], true), 404);

        $identity = Identity::first();
        $path = $identity?->{"cv_{$type}_path"};

        abort_unless($path && Storage::disk('public')->exists($path), 404);

        $filename = Str::slug($identity->name ?: 'cv') . "-{$type}-cv.pdf";

        return Storage::disk('public')->download($path, $filename);
    }
}
