<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        $educations = Education::orderByDesc('start_date')->paginate(10);

        return view('admin.education.index', compact('educations'));
    }

    public function create()
    {
        $education = new Education();

        return view('admin.education.create', compact('education'));
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        Education::create($validated);

        return redirect()
            ->route('admin.education.index')
            ->with('status', 'Education entry added.');
    }

    public function edit(Education $education)
    {
        return view('admin.education.edit', compact('education'));
    }

    public function update(Request $request, Education $education)
    {
        $validated = $this->validated($request);

        $education->update($validated);

        return redirect()
            ->route('admin.education.index')
            ->with('status', 'Education entry updated.');
    }

    public function destroy(Education $education)
    {
        $education->delete();

        return redirect()
            ->route('admin.education.index')
            ->with('status', 'Education entry deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'degree' => ['required', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'description' => ['nullable', 'string'],
        ]);
    }
}
