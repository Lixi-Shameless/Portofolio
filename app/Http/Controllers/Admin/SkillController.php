<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::orderBy('category')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.skills.index', compact('skills'));
    }

    public function create()
    {
        $skill = new Skill();

        return view('admin.skills.create', compact('skill'));
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        Skill::create($validated);

        return redirect()
            ->route('admin.skills.index')
            ->with('status', 'Skill added.');
    }

    public function edit(Skill $skill)
    {
        return view('admin.skills.edit', compact('skill'));
    }

    public function update(Request $request, Skill $skill)
    {
        $validated = $this->validated($request);

        $skill->update($validated);

        return redirect()
            ->route('admin.skills.index')
            ->with('status', 'Skill updated.');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();

        return redirect()
            ->route('admin.skills.index')
            ->with('status', 'Skill deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'proficiency' => ['required', 'integer', 'min:0', 'max:100'],
            'icon' => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer'],
        ]);
    }
}
