{{-- Shared form fields for create.blade.php and edit.blade.php --}}
<div>
    <x-input-label for="job_title" value="Job Title" />
    <x-text-input id="job_title" name="job_title" type="text" class="mt-1 block w-full"
                  value="{{ old('job_title', $experience->job_title) }}" required />
    <x-input-error :messages="$errors->get('job_title')" class="mt-2" />
</div>

<div class="grid sm:grid-cols-2 gap-6">
    <div>
        <x-input-label for="company" value="Company" />
        <x-text-input id="company" name="company" type="text" class="mt-1 block w-full"
                      value="{{ old('company', $experience->company) }}" required />
        <x-input-error :messages="$errors->get('company')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="location" value="Location" />
        <x-text-input id="location" name="location" type="text" class="mt-1 block w-full"
                      value="{{ old('location', $experience->location) }}" />
        <x-input-error :messages="$errors->get('location')" class="mt-2" />
    </div>
</div>

<div class="grid sm:grid-cols-2 gap-6">
    <div>
        <x-input-label for="start_date" value="Start Date" />
        <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full"
                      value="{{ old('start_date', optional($experience->start_date)->format('Y-m-d')) }}" required />
        <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="end_date" value="End Date" />
        <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full"
                      value="{{ old('end_date', optional($experience->end_date)->format('Y-m-d')) }}" />
        <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
    </div>
</div>

<div class="flex items-center gap-2">
    <input type="hidden" name="is_current" value="0">
    <input id="is_current" name="is_current" type="checkbox" value="1"
           class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
           {{ old('is_current', $experience->is_current) ? 'checked' : '' }}>
    <x-input-label for="is_current" value="I currently work here" class="!mb-0" />
</div>

<div>
    <x-input-label for="responsibilities" value="Key Responsibilities" />
    <textarea id="responsibilities" name="responsibilities" rows="4"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('responsibilities', $experience->responsibilities) }}</textarea>
    <x-input-error :messages="$errors->get('responsibilities')" class="mt-2" />
</div>

<div>
    <x-input-label for="achievements" value="Key Achievements" />
    <textarea id="achievements" name="achievements" rows="4"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('achievements', $experience->achievements) }}</textarea>
    <x-input-error :messages="$errors->get('achievements')" class="mt-2" />
</div>
