<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        $experiences = Experience::orderByDesc('is_current')
            ->orderByDesc('start_date')
            ->paginate(10);

        return view('admin.experience.index', compact('experiences'));
    }

    public function create()
    {
        $experience = new Experience();

        return view('admin.experience.create', compact('experience'));
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        Experience::create($validated);

        return redirect()
            ->route('admin.experience.index')
            ->with('status', 'Experience entry added.');
    }

    public function edit(Experience $experience)
    {
        return view('admin.experience.edit', compact('experience'));
    }

    public function update(Request $request, Experience $experience)
    {
        $validated = $this->validated($request);

        $experience->update($validated);

        return redirect()
            ->route('admin.experience.index')
            ->with('status', 'Experience entry updated.');
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();

        return redirect()
            ->route('admin.experience.index')
            ->with('status', 'Experience entry deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'job_title' => ['required', 'string', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_current' => ['nullable', 'boolean'],
            'responsibilities' => ['nullable', 'string'],
            'achievements' => ['nullable', 'string'],
        ]);

        $data['is_current'] = $request->boolean('is_current');

        // If marked as current, clear the end date
        if ($data['is_current']) {
            $data['end_date'] = null;
        }

        return $data;
    }
}
