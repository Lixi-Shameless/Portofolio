<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Projects') }}</h2>
            <a href="{{ route('admin.projects.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">
                + Add Project
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg p-4">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-xl overflow-hidden">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead class="bg-gray-50 text-left text-gray-500">
                        <tr>
                            <th class="px-6 py-3 font-medium">Preview</th>
                            <th class="px-6 py-3 font-medium">Title</th>
                            <th class="px-6 py-3 font-medium">Type</th>
                            <th class="px-6 py-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($projects as $project)
                            <tr>
                                <td class="px-6 py-4">
                                    @if ($project->media_path && $project->media_type === 'image')
                                        <img src="{{ $project->media_url }}" class="w-16 h-10 rounded object-cover">
                                    @elseif ($project->media_path)
                                        <video src="{{ $project->media_url }}" class="w-16 h-10 rounded object-cover" muted></video>
                                    @else
                                        <span class="text-gray-300 text-xs">No media</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $project->title }}</td>
                                <td class="px-6 py-4 text-gray-600 capitalize">{{ $project->media_type }}</td>
                                <td class="px-6 py-4 text-right space-x-3">
                                    <a href="{{ route('admin.projects.edit', $project) }}" class="text-indigo-600 hover:underline">Edit</a>
                                    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Delete this project?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic">No projects added yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $projects->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
