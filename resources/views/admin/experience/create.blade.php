<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Add Experience') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl p-8">
                <form method="POST" action="{{ route('admin.experience.store') }}" class="space-y-6">
                    @csrf
                    @include('admin.experience._form')

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.experience.index') }}"
                           class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">Cancel</a>
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
