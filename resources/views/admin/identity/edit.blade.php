<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('About Me') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg p-4">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-xl p-8">
                <form method="POST" action="{{ route('admin.identity.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Photo --}}
                    <div>
                        <x-input-label for="photo" value="Profile Photo" />
                        <div class="mt-2 flex items-center gap-4">
                            @if ($identity->photo ?? false)
                                <img src="{{ $identity->photo_url }}" class="w-16 h-16 rounded-full object-cover">
                            @endif
                            <input id="photo" name="photo" type="file" accept="image/*"
                                   class="text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                        <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                    </div>

                    {{-- CV uploads --}}
                    <div>
                        <p class="text-sm font-medium text-gray-700">CV Files (PDF, max 10MB each)</p>
                        <div class="mt-3 grid sm:grid-cols-2 gap-6">
                            @foreach (['creative' => 'Creative CV', 'formal' => 'Formal CV'] as $type => $label)
                                <div>
                                    <x-input-label for="cv_{{ $type }}" :value="$label" />
                                    <input id="cv_{{ $type }}" name="cv_{{ $type }}" type="file" accept="application/pdf"
                                           class="mt-2 text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    @if ($identity->{'cv_'.$type.'_path'})
                                        <p class="mt-1 text-xs text-green-600">Uploaded. Choose a new file to replace it.</p>
                                    @endif
                                    <x-input-error :messages="$errors->get('cv_'.$type)" class="mt-2" />
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Name --}}
                    <div>
                        <x-input-label for="name" value="Full Name" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                      value="{{ old('name', $identity->name) }}" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    {{-- Headline --}}
                    <div>
                        <x-input-label for="headline" value="Headline / Title" />
                        <x-text-input id="headline" name="headline" type="text" class="mt-1 block w-full"
                                      placeholder="e.g. Full-Stack Web Developer"
                                      value="{{ old('headline', $identity->headline) }}" />
                        <x-input-error :messages="$errors->get('headline')" class="mt-2" />
                    </div>

                    {{-- Bio --}}
                    <div>
                        <x-input-label for="bio" value="Bio" />
                        <textarea id="bio" name="bio" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('bio', $identity->bio) }}</textarea>
                        <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                    </div>

                    <div class="grid sm:grid-cols-2 gap-6">
                        {{-- Email --}}
                        <div>
                            <x-input-label for="email" value="Email" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                          value="{{ old('email', $identity->email) }}" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        {{-- Phone --}}
                        <div>
                            <x-input-label for="phone" value="Phone" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                                          value="{{ old('phone', $identity->phone) }}" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Address --}}
                    <div>
                        <x-input-label for="address" value="Address / Location" />
                        <x-text-input id="address" name="address" type="text" class="mt-1 block w-full"
                                      value="{{ old('address', $identity->address) }}" />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    <hr class="border-gray-100">

                    <p class="text-sm font-medium text-gray-700">Social Links</p>

                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="linkedin_url" value="LinkedIn URL" />
                            <x-text-input id="linkedin_url" name="linkedin_url" type="url" class="mt-1 block w-full"
                                          value="{{ old('linkedin_url', $identity->linkedin_url) }}" />
                            <x-input-error :messages="$errors->get('linkedin_url')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="github_url" value="GitHub URL" />
                            <x-text-input id="github_url" name="github_url" type="url" class="mt-1 block w-full"
                                          value="{{ old('github_url', $identity->github_url) }}" />
                            <x-input-error :messages="$errors->get('github_url')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="twitter_url" value="Twitter / X URL" />
                            <x-text-input id="twitter_url" name="twitter_url" type="url" class="mt-1 block w-full"
                                          value="{{ old('twitter_url', $identity->twitter_url) }}" />
                            <x-input-error :messages="$errors->get('twitter_url')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="website_url" value="Personal Website URL" />
                            <x-text-input id="website_url" name="website_url" type="url" class="mt-1 block w-full"
                                          value="{{ old('website_url', $identity->website_url) }}" />
                            <x-input-error :messages="$errors->get('website_url')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>{{ __('Save Changes') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
