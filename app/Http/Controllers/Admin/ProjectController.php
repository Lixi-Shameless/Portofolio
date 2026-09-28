<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('sort_order')->orderByDesc('created_at')->paginate(10);

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $project = new Project();

        return view('admin.projects.create', compact('project'));
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        if ($request->hasFile('media')) {
            $validated['media_path'] = $request->file('media')->store('projects', 'public');
        }

        Project::create($validated);

        return redirect()
            ->route('admin.projects.index')
            ->with('status', 'Project added.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $this->validated($request);

        if ($request->hasFile('media')) {
            if ($project->media_path) {
                Storage::disk('public')->delete($project->media_path);
            }
            $validated['media_path'] = $request->file('media')->store('projects', 'public');
        }

        $project->update($validated);

        return redirect()
            ->route('admin.projects.index')
            ->with('status', 'Project updated.');
    }

    public function destroy(Project $project)
    {
        if ($project->media_path) {
            Storage::disk('public')->delete($project->media_path);
        }

        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with('status', 'Project deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'media' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif,mp4,mov,webm', 'max:51200'], // 50MB max
            'media_type' => ['required', 'in:image,video'],
            'external_url' => ['nullable', 'url', 'max:255'],
            'tags' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        // 'media' is only used to populate media_path in store()/update() above,
        // it's not itself a database column.
        unset($data['media']);

        return $data;
    }
}
