@php
    $checklist = [
        ['Profile details filled in', $stats['has_identity'], route('admin.identity.edit')],
        ['Profile photo uploaded', $stats['has_photo'], route('admin.identity.edit')],
        ['Creative CV uploaded', $stats['has_cv_creative'], route('admin.identity.edit')],
        ['Formal CV uploaded', $stats['has_cv_formal'], route('admin.identity.edit')],
        ['At least one project added', $stats['project_count'] > 0, route('admin.projects.create')],
        ['At least one skill added', $stats['skill_count'] > 0, route('admin.skills.create')],
    ];
    $doneCount = collect($checklist)->where(1, true)->count();
    $cards = [
        ['Projects', $stats['project_count'], route('admin.projects.index')],
        ['Experience', $stats['experience_count'], route('admin.experience.index')],
        ['Education', $stats['education_count'], route('admin.education.index')],
        ['Skills', $stats['skill_count'], route('admin.skills.index')],
    ];
    $actions = [
        ['Add a project', route('admin.projects.create')],
        ['Add experience', route('admin.experience.create')],
        ['Add education', route('admin.education.create')],
        ['Add a skill', route('admin.skills.create')],
    ];
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 py-8 space-y-6">

        {{-- Welcome card --}}
        <div class="rounded-2xl p-6 sm:p-8 text-white bg-gradient-to-br from-slate-900 via-indigo-950 to-purple-900 shadow-sm">
            <p class="text-sm text-purple-200">Welcome back</p>
            <h3 class="mt-1 text-2xl sm:text-3xl font-extrabold tracking-tight">{{ Auth::user()->name }}</h3>
            <p class="mt-2 text-sm text-slate-300 max-w-lg">Manage everything that appears on your portfolio from here. Changes go live as soon as you save.</p>
            <div class="mt-5 flex flex-wrap gap-3">
                <a href="{{ route('portfolio.index') }}" target="_blank"
                   class="px-4 py-2 rounded-lg bg-white text-slate-900 text-sm font-semibold hover:bg-slate-100 transition">View website</a>
                <a href="{{ route('admin.identity.edit') }}"
                   class="px-4 py-2 rounded-lg border border-white/25 text-sm font-semibold hover:bg-white/10 transition">Edit profile</a>
            </div>
        </div>

        {{-- Counts --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($cards as [$label, $count, $url])
                <a href="{{ $url }}" class="group bg-white rounded-xl border border-slate-200 p-5 hover:border-purple-300 hover:shadow-md transition">
                    <p class="text-sm text-slate-500">{{ $label }}</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $count }}</p>
                    <p class="mt-2 text-xs font-medium text-purple-600 group-hover:underline">Manage &rarr;</p>
                </a>
            @endforeach
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            {{-- Checklist --}}
            <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 p-6">
                <div class="flex items-center justify-between">
                    <h4 class="font-semibold text-slate-900">Portfolio checklist</h4>
                    <span class="text-xs font-medium text-slate-500">{{ $doneCount }} of {{ count($checklist) }} done</span>
                </div>
                <div class="mt-3 h-1.5 rounded-full bg-slate-100 overflow-hidden">
                    <div class="h-full rounded-full bg-gradient-to-r from-purple-500 to-indigo-500" style="width: {{ ($doneCount / count($checklist)) * 100 }}%"></div>
                </div>
                <ul class="mt-4 divide-y divide-slate-100">
                    @foreach ($checklist as [$label, $done, $url])
                        <li>
                            <a href="{{ $url }}" class="flex items-center gap-3 py-3 text-sm hover:text-purple-600 transition">
                                @if ($done)
                                    <span class="w-5 h-5 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-xs">&#10003;</span>
                                    <span class="text-slate-500">{{ $label }}</span>
                                @else
                                    <span class="w-5 h-5 rounded-full border-2 border-slate-300"></span>
                                    <span class="font-medium text-slate-800">{{ $label }}</span>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Quick actions --}}
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h4 class="font-semibold text-slate-900">Quick actions</h4>
                <div class="mt-4 space-y-2">
                    @foreach ($actions as [$label, $url])
                        <a href="{{ $url }}" class="flex items-center justify-between px-4 py-3 rounded-lg bg-slate-50 text-sm font-medium text-slate-700 hover:bg-purple-50 hover:text-purple-700 transition">
                            {{ $label }} <span aria-hidden="true">+</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
