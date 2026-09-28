{{-- Shared form fields for create.blade.php and edit.blade.php --}}
<div>
    <x-input-label for="degree" value="Degree / Qualification" />
    <x-text-input id="degree" name="degree" type="text" class="mt-1 block w-full"
                  value="{{ old('degree', $education->degree) }}" required />
    <x-input-error :messages="$errors->get('degree')" class="mt-2" />
</div>

<div>
    <x-input-label for="institution" value="Institution" />
    <x-text-input id="institution" name="institution" type="text" class="mt-1 block w-full"
                  value="{{ old('institution', $education->institution) }}" required />
    <x-input-error :messages="$errors->get('institution')" class="mt-2" />
</div>

<div class="grid sm:grid-cols-2 gap-6">
    <div>
        <x-input-label for="start_date" value="Start Date" />
        <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full"
                      value="{{ old('start_date', optional($education->start_date)->format('Y-m-d')) }}" required />
        <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="end_date" value="End Date (leave blank if ongoing)" />
        <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full"
                      value="{{ old('end_date', optional($education->end_date)->format('Y-m-d')) }}" />
        <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
    </div>
</div>

<div>
    <x-input-label for="description" value="Description" />
    <textarea id="description" name="description" rows="4"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $education->description) }}</textarea>
    <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>
