{{--
    Drop this into resources/views/layouts/navigation.blade.php (Breeze already
    creates that file) OR include it inside your x-app-layout header — it adds
    links to the portfolio admin sections alongside Breeze's default nav.
    Shown here as a standalone partial you can merge in.
--}}
<div class="flex space-x-4">
    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
        {{ __('Dashboard') }}
    </x-nav-link>
    <x-nav-link :href="route('admin.identity.edit')" :active="request()->routeIs('admin.identity.*')">
        {{ __('About Me') }}
    </x-nav-link>
    <x-nav-link :href="route('admin.education.index')" :active="request()->routeIs('admin.education.*')">
        {{ __('Education') }}
    </x-nav-link>
    <x-nav-link :href="route('admin.experience.index')" :active="request()->routeIs('admin.experience.*')">
        {{ __('Experience') }}
    </x-nav-link>
    <x-nav-link :href="route('admin.skills.index')" :active="request()->routeIs('admin.skills.*')">
        {{ __('Skills') }}
    </x-nav-link>
</div>
