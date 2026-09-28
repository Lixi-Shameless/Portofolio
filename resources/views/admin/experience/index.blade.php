<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Work Experience') }}</h2>
            <a href="{{ route('admin.experience.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">
                + Add Experience
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
                            <th class="px-6 py-3 font-medium">Job Title</th>
                            <th class="px-6 py-3 font-medium">Company</th>
                            <th class="px-6 py-3 font-medium">Period</th>
                            <th class="px-6 py-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($experiences as $experience)
                            <tr>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $experience->job_title }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $experience->company }}</td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $experience->start_date->format('M Y') }} –
                                    {{ $experience->is_current ? 'Present' : ($experience->end_date?->format('M Y') ?? 'Present') }}
                                </td>
                                <td class="px-6 py-4 text-right space-x-3">
                                    <a href="{{ route('admin.experience.edit', $experience) }}" class="text-indigo-600 hover:underline">Edit</a>
                                    <form action="{{ route('admin.experience.destroy', $experience) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Delete this experience entry?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic">No experience entries yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $experiences->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
