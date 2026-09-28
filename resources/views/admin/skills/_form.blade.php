{{-- Shared form fields for create.blade.php and edit.blade.php --}}
<div>
    <x-input-label for="name" value="Skill Name" />
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                  value="{{ old('name', $skill->name) }}" required />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div>
    <x-input-label for="category" value="Category" />
    <input list="category-list" id="category" name="category"
           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
           value="{{ old('category', $skill->category) }}" required>
    <datalist id="category-list">
        @foreach (\App\Models\Skill::CATEGORIES as $category)
            <option value="{{ $category }}">
        @endforeach
    </datalist>
    <p class="mt-1 text-xs text-gray-400">e.g. Frontend, Backend, Database, Tools — type a new one if you like.</p>
    <x-input-error :messages="$errors->get('category')" class="mt-2" />
</div>

<div class="grid sm:grid-cols-2 gap-6">
    <div>
        <x-input-label for="proficiency" value="Proficiency (0-100)" />
        <x-text-input id="proficiency" name="proficiency" type="number" min="0" max="100" class="mt-1 block w-full"
                      value="{{ old('proficiency', $skill->proficiency ?? 80) }}" required />
        <x-input-error :messages="$errors->get('proficiency')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="icon" value="Icon (emoji or class, optional)" />
        <x-text-input id="icon" name="icon" type="text" class="mt-1 block w-full"
                      placeholder="e.g. 🚀 or fa-brands fa-laravel"
                      value="{{ old('icon', $skill->icon) }}" />
        <x-input-error :messages="$errors->get('icon')" class="mt-2" />
    </div>
</div>

<div>
    <x-input-label for="sort_order" value="Sort Order (lower shows first)" />
    <x-text-input id="sort_order" name="sort_order" type="number" class="mt-1 block w-full"
                  value="{{ old('sort_order', $skill->sort_order ?? 0) }}" />
    <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
</div>
