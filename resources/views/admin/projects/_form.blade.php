{{-- Shared form fields for create.blade.php and edit.blade.php --}}
<div>
    <x-input-label for="title" value="Project Title" />
    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                  value="{{ old('title', $project->title) }}" required />
    <x-input-error :messages="$errors->get('title')" class="mt-2" />
</div>

<div>
    <x-input-label for="description" value="Description" />
    <textarea id="description" name="description" rows="4"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $project->description) }}</textarea>
    <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>

<div>
    <x-input-label for="media_type" value="Media Type" />
    <select id="media_type" name="media_type"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value="image" {{ old('media_type', $project->media_type) === 'image' ? 'selected' : '' }}>Image / Screenshot</option>
        <option value="video" {{ old('media_type', $project->media_type) === 'video' ? 'selected' : '' }}>Short Video (mp4/webm/mov)</option>
    </select>
    <x-input-error :messages="$errors->get('media_type')" class="mt-2" />
</div>

<div>
    <x-input-label for="media" value="Upload Media" />
    <div class="mt-2 flex items-center gap-4">
        @if ($project->media_path)
            @if ($project->media_type === 'video')
                <video src="{{ $project->media_url }}" class="w-24 h-16 rounded object-cover" muted></video>
            @else
                <img src="{{ $project->media_url }}" class="w-24 h-16 rounded object-cover">
            @endif
        @endif
        <input id="media" name="media" type="file" accept="image/*,video/mp4,video/webm,video/quicktime"
               class="text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
    </div>
    <p class="mt-1 text-xs text-gray-400">Images or short video clips, up to 20MB. Keep clips short (a few seconds) for fast loading.</p>
    <x-input-error :messages="$errors->get('media')" class="mt-2" />
</div>

<div>
    <x-input-label for="external_url" value="Project Link (optional)" />
    <x-text-input id="external_url" name="external_url" type="url" class="mt-1 block w-full"
                  placeholder="https://..." value="{{ old('external_url', $project->external_url) }}" />
    <x-input-error :messages="$errors->get('external_url')" class="mt-2" />
</div>

<div>
    <x-input-label for="tags" value="Tags (comma-separated)" />
    <x-text-input id="tags" name="tags" type="text" class="mt-1 block w-full"
                  placeholder="e.g. SQL, Power BI, Python" value="{{ old('tags', $project->tags) }}" />
    <x-input-error :messages="$errors->get('tags')" class="mt-2" />
</div>

<div>
    <x-input-label for="sort_order" value="Sort Order (lower shows first)" />
    <x-text-input id="sort_order" name="sort_order" type="number" class="mt-1 block w-full"
                  value="{{ old('sort_order', $project->sort_order ?? 0) }}" />
    <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
</div>
