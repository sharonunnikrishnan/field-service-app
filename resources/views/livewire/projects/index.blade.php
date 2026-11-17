@php
    $getBadgeStyles = function ($status) {
        return match ($status) {
            'in-progress' => [
                'bg' => 'bg-sky-50 dark:bg-sky-950/40',
                'text' => 'text-sky-700 dark:text-sky-300',
                'border' => 'border-sky-200 dark:border-sky-800/60',
                'dot' => 'bg-sky-500',
            ],
            'completed' => [
                'bg' => 'bg-emerald-50 dark:bg-emerald-950/40',
                'text' => 'text-emerald-700 dark:text-emerald-300',
                'border' => 'border-emerald-200 dark:border-emerald-800/60',
                'dot' => 'bg-emerald-500',
            ],
            'pending' => [
                'bg' => 'bg-amber-50 dark:bg-amber-950/40',
                'text' => 'text-amber-700 dark:text-amber-300',
                'border' => 'border-amber-200 dark:border-amber-800/60',
                'dot' => 'bg-amber-500',
            ],
            'cancelled' => [
                'bg' => 'bg-rose-50 dark:bg-rose-950/40',
                'text' => 'text-rose-700 dark:text-rose-300',
                'border' => 'border-rose-200 dark:border-rose-800/60',
                'dot' => 'bg-rose-500',
            ],
            default => [
                'bg' => 'bg-zinc-50 dark:bg-zinc-800',
                'text' => 'text-zinc-700 dark:text-zinc-300',
                'border' => 'border-zinc-200 dark:border-zinc-700',
                'dot' => 'bg-zinc-400',
            ],
        };
    };
@endphp

<div class="space-y-6">
    {{-- Header Section --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-3">
                <flux:heading size="xl" level="1" class="font-bold tracking-tight text-zinc-900 dark:text-white">
                    {{ __('Project Management') }}
                </flux:heading>
                <flux:badge size="sm" color="lime" class="font-semibold">
                    {{ $statusCounts['all'] }} {{ __('Total') }}
                </flux:badge>
            </div>
            <flux:subheading size="lg" class="mt-1 text-zinc-500 dark:text-zinc-400">
                {{ __('Monitor, search, and manage all your projects in real-time') }}
            </flux:subheading>
        </div>

        <div class="flex items-center gap-2">
            <flux:modal.trigger name="project-modal">
                <flux:button wire:click="$dispatch('open-project-modal', { mode: 'create' })" variant="primary"
                    color="lime" icon="plus" class="w-full sm:w-auto cursor-pointer shadow-sm hover:shadow transition-all">
                    {{ __('Add Project') }}
                </flux:button>
            </flux:modal.trigger>
        </div>
    </div>

    {{-- Render Form Component --}}
    <livewire:projects.form-modal />

    {{-- Flash Message Notification --}}
    <div x-data="{ show: false, message: '', type: '' }" x-init="window.addEventListener('flash', e => {
        const data = e.detail[0];
        message = data.message;
        type = data.type;
        show = true;
    
        setTimeout(() => {
            show = false;
        }, 4000);
    });" x-show="show"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-500"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed top-5 right-5 px-4 py-3 rounded-xl shadow-xl text-white z-50 flex items-center gap-2 border text-sm font-medium"
        :class="{
            'bg-emerald-600 border-emerald-500': type === 'success',
            'bg-rose-600 border-rose-500': type === 'error'
        }"
        style="display: none;">
        <flux:icon.check-circle x-show="type === 'success'" class="size-5 shrink-0" />
        <flux:icon.exclamation-circle x-show="type === 'error'" class="size-5 shrink-0" />
        <span x-text="message"></span>
    </div>

    {{-- KPI / Status Quick Filter Cards --}}
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4 lg:gap-4">
        {{-- All Projects Card --}}
        <button type="button" wire:click="setStatus('all')"
            class="text-left rounded-2xl p-3.5 sm:p-4 transition-all duration-200 border cursor-pointer {{ $status === 'all' ? 'bg-lime-500/10 border-lime-500 dark:border-lime-400 ring-2 ring-lime-500/30' : 'bg-white dark:bg-zinc-900 border-zinc-200/80 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-700 shadow-2xs' }}">
            <div class="flex items-center justify-between">
                <span class="text-[11px] sm:text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">All
                    Projects</span>
                <span class="p-1.5 sm:p-2 rounded-xl bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300">
                    <flux:icon.folder class="size-3.5 sm:size-4" />
                </span>
            </div>
            <div class="mt-2 flex items-baseline gap-2">
                <span
                    class="text-xl sm:text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $statusCounts['all'] }}</span>
                <span class="text-xs text-zinc-500 dark:text-zinc-400">total</span>
            </div>
        </button>

        {{-- In Progress Card --}}
        <button type="button" wire:click="setStatus('in-progress')"
            class="text-left rounded-2xl p-3.5 sm:p-4 transition-all duration-200 border cursor-pointer {{ $status === 'in-progress' ? 'bg-sky-500/10 border-sky-500 dark:border-sky-400 ring-2 ring-sky-500/30' : 'bg-white dark:bg-zinc-900 border-zinc-200/80 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-700 shadow-2xs' }}">
            <div class="flex items-center justify-between">
                <span class="text-[11px] sm:text-xs font-medium uppercase tracking-wider text-sky-600 dark:text-sky-400">In
                    Progress</span>
                <span class="p-1.5 sm:p-2 rounded-xl bg-sky-50 dark:bg-sky-950/50 text-sky-600 dark:text-sky-400">
                    <flux:icon.arrow-path class="size-3.5 sm:size-4 animate-spin-slow" />
                </span>
            </div>
            <div class="mt-2 flex items-baseline gap-2">
                <span
                    class="text-xl sm:text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $statusCounts['in-progress'] }}</span>
                <span class="text-xs text-sky-600/80 dark:text-sky-400/80 font-medium">active</span>
            </div>
        </button>

        {{-- Pending Card --}}
        <button type="button" wire:click="setStatus('pending')"
            class="text-left rounded-2xl p-3.5 sm:p-4 transition-all duration-200 border cursor-pointer {{ $status === 'pending' ? 'bg-amber-500/10 border-amber-500 dark:border-amber-400 ring-2 ring-amber-500/30' : 'bg-white dark:bg-zinc-900 border-zinc-200/80 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-700 shadow-2xs' }}">
            <div class="flex items-center justify-between">
                <span
                    class="text-[11px] sm:text-xs font-medium uppercase tracking-wider text-amber-600 dark:text-amber-400">Pending</span>
                <span class="p-1.5 sm:p-2 rounded-xl bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400">
                    <flux:icon.clock class="size-3.5 sm:size-4" />
                </span>
            </div>
            <div class="mt-2 flex items-baseline gap-2">
                <span
                    class="text-xl sm:text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $statusCounts['pending'] }}</span>
                <span class="text-xs text-amber-600/80 dark:text-amber-400/80 font-medium">queued</span>
            </div>
        </button>

        {{-- Completed Card --}}
        <button type="button" wire:click="setStatus('completed')"
            class="text-left rounded-2xl p-3.5 sm:p-4 transition-all duration-200 border cursor-pointer {{ $status === 'completed' ? 'bg-emerald-500/10 border-emerald-500 dark:border-emerald-400 ring-2 ring-emerald-500/30' : 'bg-white dark:bg-zinc-900 border-zinc-200/80 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-700 shadow-2xs' }}">
            <div class="flex items-center justify-between">
                <span
                    class="text-[11px] sm:text-xs font-medium uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Completed</span>
                <span class="p-1.5 sm:p-2 rounded-xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400">
                    <flux:icon.check-circle class="size-3.5 sm:size-4" />
                </span>
            </div>
            <div class="mt-2 flex items-baseline gap-2">
                <span
                    class="text-xl sm:text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $statusCounts['completed'] }}</span>
                <span class="text-xs text-emerald-600/80 dark:text-emerald-400/80 font-medium">done</span>
            </div>
        </button>
    </div>

    {{-- Control & Filter Toolbar --}}
    <div
        class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-2xl p-3.5 sm:p-4 shadow-2xs space-y-3">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            {{-- Dynamic Search Box with Instant Typing Filtering --}}
            <div class="relative flex-1 w-full lg:max-w-lg">
                <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass"
                    placeholder="Search projects by name or description..." clearable class="w-full" />
            </div>

            {{-- Filter & Control Operations --}}
            <div class="grid grid-cols-2 sm:flex sm:flex-wrap items-center gap-2">
                {{-- Status Dropdown Filter --}}
                <div class="col-span-1 sm:w-40">
                    <flux:select wire:model.live="status" placeholder="Filter Status">
                        <flux:select.option value="all">All Statuses</flux:select.option>
                        <flux:select.option value="in-progress">In-Progress</flux:select.option>
                        <flux:select.option value="pending">Pending</flux:select.option>
                        <flux:select.option value="completed">Completed</flux:select.option>
                        <flux:select.option value="cancelled">Cancelled</flux:select.option>
                    </flux:select>
                </div>

                {{-- Sort Column Dropdown --}}
                <div class="col-span-1 sm:w-36">
                    <flux:select wire:model.live="sortField" placeholder="Sort By">
                        <flux:select.option value="id">Recent</flux:select.option>
                        <flux:select.option value="name">Name</flux:select.option>
                        <flux:select.option value="status">Status</flux:select.option>
                        <flux:select.option value="deadline">Deadline</flux:select.option>
                    </flux:select>
                </div>

                {{-- Sort Direction Toggle Button --}}
                <div class="col-span-1 sm:w-auto">
                    <flux:button
                        wire:click="$set('sortDirection', '{{ $sortDirection === 'asc' ? 'desc' : 'asc' }}')"
                        variant="subtle"
                        icon="{{ $sortDirection === 'asc' ? 'bars-arrow-up' : 'bars-arrow-down' }}"
                        title="Toggle sort direction (Current: {{ strtoupper($sortDirection) }})"
                        class="w-full sm:w-auto cursor-pointer justify-center">
                        {{ strtoupper($sortDirection) }}
                    </flux:button>
                </div>

                {{-- Per Page Selector --}}
                <div class="col-span-1 sm:w-24">
                    <flux:select wire:model.live="perPage">
                        <flux:select.option value="10">10 / pg</flux:select.option>
                        <flux:select.option value="25">25 / pg</flux:select.option>
                        <flux:select.option value="50">50 / pg</flux:select.option>
                    </flux:select>
                </div>

                {{-- Reset Filters Button (Visible when filters are active) --}}
                @if ($search !== '' || $status !== 'all' || $sortField !== 'id' || $sortDirection !== 'desc' || $perPage !== 10)
                    <div class="col-span-2 sm:col-span-1 sm:w-auto">
                        <flux:button wire:click="resetFilters" variant="ghost" icon="arrow-path"
                            class="w-full sm:w-auto cursor-pointer text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-200 justify-center">
                            {{ __('Reset') }}
                        </flux:button>
                    </div>
                @endif
            </div>
        </div>

        {{-- Active Filter Chips & Feedback Bar --}}
        <div
            class="flex flex-wrap items-center justify-between gap-2 pt-2 border-t border-zinc-100 dark:border-zinc-800 text-xs text-zinc-500 dark:text-zinc-400">
            <div class="flex flex-wrap items-center gap-2">
                <span class="font-medium text-zinc-700 dark:text-zinc-300">
                    Showing {{ $projects->firstItem() ?? 0 }}-{{ $projects->lastItem() ?? 0 }} of
                    {{ $projects->total() }} results
                </span>

                {{-- Livewire Keystroke Loading Indicator --}}
                <span wire:loading wire:target="search, status, sortField, sortDirection, perPage"
                    class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-lime-500/10 text-lime-700 dark:text-lime-400 font-medium">
                    <flux:icon.arrow-path class="size-3 animate-spin" />
                    Searching...
                </span>

                @if ($search !== '')
                    <span
                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-medium">
                        Search: "{{ $search }}"
                        <button type="button" wire:click="clearSearch"
                            class="hover:text-zinc-900 dark:hover:text-white cursor-pointer ml-0.5">
                            <flux:icon.x-mark class="size-3" />
                        </button>
                    </span>
                @endif

                @if ($status !== 'all')
                    <span
                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-medium">
                        Status: {{ ucfirst($status) }}
                        <button type="button" wire:click="setStatus('all')"
                            class="hover:text-zinc-900 dark:hover:text-white cursor-pointer ml-0.5">
                            <flux:icon.x-mark class="size-3" />
                        </button>
                    </span>
                @endif
            </div>

            @if ($search !== '' || $status !== 'all')
                <button type="button" wire:click="resetFilters"
                    class="text-xs text-lime-600 dark:text-lime-400 hover:underline font-medium cursor-pointer">
                    Clear all filters
                </button>
            @endif
        </div>
    </div>

    {{-- Projects Container (Desktop Table + Mobile Responsive Blocks) --}}
    <div
        class="relative overflow-hidden rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-2xs">
        {{-- Subtle loading overlay --}}
        <div wire:loading.delay wire:target="search, status, sortField, sortDirection, perPage"
            class="absolute inset-0 bg-white/50 dark:bg-zinc-900/50 backdrop-blur-2xs z-20 flex items-center justify-center">
            <div
                class="flex items-center gap-2 px-4 py-2 rounded-xl bg-white dark:bg-zinc-800 shadow-lg border border-zinc-200 dark:border-zinc-700 text-xs font-semibold text-zinc-700 dark:text-zinc-200">
                <flux:icon.arrow-path class="size-4 animate-spin text-lime-600 dark:text-lime-400" />
                Updating projects...
            </div>
        </div>

        @if ($projects->isEmpty())
            {{-- Unified Empty State --}}
            <div class="py-12 px-4 text-center">
                <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                    <div class="p-4 rounded-2xl bg-zinc-100 dark:bg-zinc-800 text-zinc-400 dark:text-zinc-500 mb-3">
                        <flux:icon.magnifying-glass class="size-8" />
                    </div>
                    <h3 class="text-base font-semibold text-zinc-900 dark:text-white">
                        {{ $search !== '' || $status !== 'all' ? __('No matching projects found') : __('No projects yet') }}
                    </h3>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                        @if ($search !== '')
                            We couldn't find any projects matching "<span
                                class="font-medium text-zinc-800 dark:text-zinc-200">{{ $search }}</span>".
                        @elseif($status !== 'all')
                            There are no projects with the status "{{ ucfirst($status) }}".
                        @else
                            Get started by adding your first project to the platform.
                        @endif
                    </p>
                    <div class="mt-4">
                        @if ($search !== '' || $status !== 'all')
                            <flux:button wire:click="resetFilters" size="sm" variant="subtle" icon="arrow-path"
                                class="cursor-pointer">
                                {{ __('Clear Filters') }}
                            </flux:button>
                        @else
                            <flux:modal.trigger name="project-modal">
                                <flux:button wire:click="$dispatch('open-project-modal', { mode: 'create' })" size="sm"
                                    variant="primary" color="lime" icon="plus" class="cursor-pointer">
                                    {{ __('Add Project') }}
                                </flux:button>
                            </flux:modal.trigger>
                        @endif
                    </div>
                </div>
            </div>
        @else
            {{-- DESKTOP VIEW: Traditional full-featured table (hidden on mobile) --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800 text-sm text-left">
                    <thead
                        class="bg-zinc-50/80 dark:bg-zinc-800/60 text-zinc-600 dark:text-zinc-400 text-xs font-semibold uppercase tracking-wider">
                        <tr>
                            <th scope="col" class="py-3.5 px-4 w-12 text-zinc-400">#</th>

                            {{-- Sortable Name Column --}}
                            <th scope="col" class="py-3.5 px-4">
                                <button type="button" wire:click="sortBy('name')"
                                    class="group flex items-center gap-1.5 uppercase font-semibold hover:text-zinc-900 dark:hover:text-white cursor-pointer transition">
                                    <span>{{ __('Project') }}</span>
                                    <span class="text-zinc-400 group-hover:text-zinc-800 dark:group-hover:text-zinc-200">
                                        @if ($sortField === 'name')
                                            <flux:icon icon="{{ $sortDirection === 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                                class="size-3.5 text-lime-600 dark:text-lime-400" />
                                        @else
                                            <flux:icon.chevron-up-down class="size-3.5 opacity-40 group-hover:opacity-100" />
                                        @endif
                                    </span>
                                </button>
                            </th>

                            <th scope="col" class="py-3.5 px-4">{{ __('Description') }}</th>

                            {{-- Sortable Status Column --}}
                            <th scope="col" class="py-3.5 px-4">
                                <button type="button" wire:click="sortBy('status')"
                                    class="group flex items-center gap-1.5 uppercase font-semibold hover:text-zinc-900 dark:hover:text-white cursor-pointer transition">
                                    <span>{{ __('Status') }}</span>
                                    <span class="text-zinc-400 group-hover:text-zinc-800 dark:group-hover:text-zinc-200">
                                        @if ($sortField === 'status')
                                            <flux:icon icon="{{ $sortDirection === 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                                class="size-3.5 text-lime-600 dark:text-lime-400" />
                                        @else
                                            <flux:icon.chevron-up-down class="size-3.5 opacity-40 group-hover:opacity-100" />
                                        @endif
                                    </span>
                                </button>
                            </th>

                            {{-- Sortable Deadline Column --}}
                            <th scope="col" class="py-3.5 px-4">
                                <button type="button" wire:click="sortBy('deadline')"
                                    class="group flex items-center gap-1.5 uppercase font-semibold hover:text-zinc-900 dark:hover:text-white cursor-pointer transition">
                                    <span>{{ __('Deadline') }}</span>
                                    <span class="text-zinc-400 group-hover:text-zinc-800 dark:group-hover:text-zinc-200">
                                        @if ($sortField === 'deadline')
                                            <flux:icon icon="{{ $sortDirection === 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                                class="size-3.5 text-lime-600 dark:text-lime-400" />
                                        @else
                                            <flux:icon.chevron-up-down class="size-3.5 opacity-40 group-hover:opacity-100" />
                                        @endif
                                    </span>
                                </button>
                            </th>

                            <th scope="col" class="py-3.5 px-4">{{ __('Logo') }}</th>
                            <th scope="col" class="py-3.5 px-4 text-center">{{ __('Actions') }}</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/80">
                        @foreach ($projects as $project)
                            @php $badgeStyles = $getBadgeStyles($project->status); @endphp
                            <tr wire:key="project-row-{{ $project->id }}"
                                class="hover:bg-zinc-50/80 dark:hover:bg-zinc-800/40 transition-colors">
                                {{-- Index --}}
                                <td class="py-3.5 px-4 text-xs text-zinc-400 font-mono">
                                    {{ ($projects->firstItem() ?? 1) + $loop->index }}
                                </td>

                                {{-- Project Name & Slug --}}
                                <td class="py-3.5 px-4">
                                    <div class="font-semibold text-zinc-900 dark:text-zinc-100 leading-snug">
                                        {{ $project->name }}
                                    </div>
                                    @if ($project->slug)
                                        <div class="text-xs text-zinc-400 dark:text-zinc-500 font-mono mt-0.5">
                                            /{{ $project->slug }}
                                        </div>
                                    @endif
                                </td>

                                {{-- Description --}}
                                <td class="py-3.5 px-4 max-w-xs">
                                    <p class="text-zinc-600 dark:text-zinc-300 text-xs line-clamp-2 leading-relaxed"
                                        title="{{ $project->description }}">
                                        {{ $project->description }}
                                    </p>
                                </td>

                                {{-- Status Badge --}}
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border {{ $badgeStyles['bg'] }} {{ $badgeStyles['text'] }} {{ $badgeStyles['border'] }}">
                                        <span class="size-1.5 rounded-full {{ $badgeStyles['dot'] }}"></span>
                                        <span class="capitalize">{{ $project->status }}</span>
                                    </span>
                                </td>

                                {{-- Deadline --}}
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    @if ($project->deadline)
                                        @php
                                            $deadlineDate = \Carbon\Carbon::parse($project->deadline);
                                            $isOverdue = $deadlineDate->isPast() && $project->status !== 'completed';
                                        @endphp
                                        <div
                                            class="flex items-center gap-1.5 text-xs {{ $isOverdue ? 'text-rose-600 dark:text-rose-400 font-semibold' : 'text-zinc-600 dark:text-zinc-300' }}">
                                            <flux:icon.calendar class="size-3.5 text-zinc-400" />
                                            <span>{{ $deadlineDate->format('M d, Y') }}</span>
                                        </div>
                                        <div
                                            class="text-[11px] {{ $isOverdue ? 'text-rose-500 font-medium' : 'text-zinc-400' }} mt-0.5">
                                            {{ $deadlineDate->diffForHumans() }}
                                        </div>
                                    @else
                                        <span class="text-zinc-400 text-xs">—</span>
                                    @endif
                                </td>

                                {{-- Logo --}}
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    @if ($project->project_logo)
                                        <img src="{{ asset('storage/' . $project->project_logo) }}"
                                            alt="{{ $project->name }} logo"
                                            class="h-10 w-16 object-cover rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-2xs hover:scale-105 transition-transform" />
                                    @else
                                        <div
                                            class="h-10 w-14 rounded-lg bg-zinc-100 dark:bg-zinc-800 border border-dashed border-zinc-300 dark:border-zinc-700 flex items-center justify-center text-zinc-400 dark:text-zinc-500">
                                            <flux:icon.photo class="size-4 opacity-50" />
                                        </div>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="py-3.5 px-4 whitespace-nowrap text-center">
                                    <div class="inline-flex items-center gap-1">
                                        {{-- View Button --}}
                                        <flux:modal.trigger name="project-modal">
                                            <flux:button
                                                wire:click="$dispatch('open-project-modal', { mode: 'view', project: {{ $project }} })"
                                                size="sm" variant="subtle" icon="eye" title="View Project"
                                                aria-label="View Project"
                                                class="cursor-pointer text-zinc-600 hover:text-sky-600 dark:text-zinc-300 dark:hover:text-sky-400">
                                            </flux:button>
                                        </flux:modal.trigger>

                                        {{-- Edit Button --}}
                                        <flux:modal.trigger name="project-modal">
                                            <flux:button
                                                wire:click="$dispatch('open-project-modal', { mode: 'edit', project: {{ $project }} })"
                                                size="sm" variant="subtle" icon="pencil-square" title="Edit Project"
                                                aria-label="Edit Project"
                                                class="cursor-pointer text-zinc-600 hover:text-blue-600 dark:text-zinc-300 dark:hover:text-blue-400">
                                            </flux:button>
                                        </flux:modal.trigger>

                                        {{-- Delete Button --}}
                                        <flux:modal.trigger name="delete-project">
                                            <flux:button
                                                wire:click="$dispatch('delete-project', { id: {{ $project->id }} })"
                                                size="sm" variant="subtle" icon="trash" title="Delete Project"
                                                aria-label="Delete Project"
                                                class="cursor-pointer text-zinc-600 hover:text-rose-600 dark:text-zinc-300 dark:hover:text-rose-400">
                                            </flux:button>
                                        </flux:modal.trigger>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- MOBILE VIEW: Individual Responsive Blocks/Cards (visible only on mobile) --}}
            <div class="block md:hidden divide-y divide-zinc-200/80 dark:divide-zinc-800/80">
                @foreach ($projects as $project)
                    @php $badgeStyles = $getBadgeStyles($project->status); @endphp
                    <div wire:key="project-mobile-{{ $project->id }}"
                        class="p-4 space-y-3.5 transition-colors hover:bg-zinc-50/70 dark:hover:bg-zinc-800/40">
                        {{-- Block Top Row: Logo, Project Name, Slug & Status Badge --}}
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-3 min-w-0">
                                {{-- Logo / Fallback Icon --}}
                                @if ($project->project_logo)
                                    <img src="{{ asset('storage/' . $project->project_logo) }}"
                                        alt="{{ $project->name }} logo"
                                        class="size-11 shrink-0 object-cover rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-2xs" />
                                @else
                                    <div
                                        class="size-11 shrink-0 rounded-xl bg-lime-500/10 text-lime-600 dark:text-lime-400 border border-lime-500/20 flex items-center justify-center font-bold text-sm">
                                        <flux:icon.folder class="size-5" />
                                    </div>
                                @endif

                                {{-- Name & Slug --}}
                                <div class="min-w-0">
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-xs text-zinc-400 font-mono">#{{ ($projects->firstItem() ?? 1) + $loop->index }}</span>
                                        <h3 class="font-semibold text-zinc-900 dark:text-zinc-100 text-sm truncate">
                                            {{ $project->name }}
                                        </h3>
                                    </div>
                                    @if ($project->slug)
                                        <div class="text-xs text-zinc-400 dark:text-zinc-500 font-mono truncate mt-0.5">
                                            /{{ $project->slug }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Status Pill Badge --}}
                            <div class="shrink-0">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border {{ $badgeStyles['bg'] }} {{ $badgeStyles['text'] }} {{ $badgeStyles['border'] }}">
                                    <span class="size-1.5 rounded-full {{ $badgeStyles['dot'] }}"></span>
                                    <span class="capitalize">{{ $project->status }}</span>
                                </span>
                            </div>
                        </div>

                        {{-- Description Block --}}
                        @if ($project->description)
                            <p
                                class="text-xs text-zinc-600 dark:text-zinc-300 line-clamp-2 leading-relaxed bg-zinc-50/90 dark:bg-zinc-800/40 rounded-xl p-2.5 border border-zinc-100 dark:border-zinc-800/80">
                                {{ $project->description }}
                            </p>
                        @endif

                        {{-- Block Footer: Deadline & Action Buttons --}}
                        <div
                            class="flex items-center justify-between gap-2 pt-2 border-t border-zinc-100/80 dark:border-zinc-800/60">
                            {{-- Deadline Info --}}
                            <div>
                                @if ($project->deadline)
                                    @php
                                        $deadlineDate = \Carbon\Carbon::parse($project->deadline);
                                        $isOverdue = $deadlineDate->isPast() && $project->status !== 'completed';
                                    @endphp
                                    <div
                                        class="flex items-center gap-1.5 text-xs {{ $isOverdue ? 'text-rose-600 dark:text-rose-400 font-semibold' : 'text-zinc-600 dark:text-zinc-300' }}">
                                        <flux:icon.calendar class="size-3.5 text-zinc-400 shrink-0" />
                                        <span>{{ $deadlineDate->format('M d, Y') }}</span>
                                    </div>
                                    <div
                                        class="text-[11px] {{ $isOverdue ? 'text-rose-500 font-medium' : 'text-zinc-400' }} mt-0.5">
                                        {{ $deadlineDate->diffForHumans() }}
                                    </div>
                                @else
                                    <span class="text-zinc-400 text-xs">—</span>
                                @endif
                            </div>

                            {{-- Action Buttons --}}
                            <div class="inline-flex items-center gap-1.5 shrink-0">
                                {{-- View Button --}}
                                <flux:modal.trigger name="project-modal">
                                    <flux:button
                                        wire:click="$dispatch('open-project-modal', { mode: 'view', project: {{ $project }} })"
                                        size="sm" variant="subtle" icon="eye" title="View Project"
                                        aria-label="View Project"
                                        class="cursor-pointer text-zinc-600 hover:text-sky-600 dark:text-zinc-300 dark:hover:text-sky-400">
                                    </flux:button>
                                </flux:modal.trigger>

                                {{-- Edit Button --}}
                                <flux:modal.trigger name="project-modal">
                                    <flux:button
                                        wire:click="$dispatch('open-project-modal', { mode: 'edit', project: {{ $project }} })"
                                        size="sm" variant="subtle" icon="pencil-square" title="Edit Project"
                                        aria-label="Edit Project"
                                        class="cursor-pointer text-zinc-600 hover:text-blue-600 dark:text-zinc-300 dark:hover:text-blue-400">
                                    </flux:button>
                                </flux:modal.trigger>

                                {{-- Delete Button --}}
                                <flux:modal.trigger name="delete-project">
                                    <flux:button
                                        wire:click="$dispatch('delete-project', { id: {{ $project->id }} })"
                                        size="sm" variant="subtle" icon="trash" title="Delete Project"
                                        aria-label="Delete Project"
                                        class="cursor-pointer text-zinc-600 hover:text-rose-600 dark:text-zinc-300 dark:hover:text-rose-400">
                                    </flux:button>
                                </flux:modal.trigger>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Pagination Bar --}}
    @if ($projects->hasPages())
        <div class="pt-2">
            {{ $projects->links() }}
        </div>
    @endif

    {{-- Delete Confirmation Modal --}}
    <flux:modal name="delete-project" class="min-w-0 max-w-md w-[calc(100vw-2rem)] sm:w-auto">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg" class="text-zinc-900 dark:text-white font-bold">
                    {{ __('Delete project?') }}
                </flux:heading>
                <flux:text class="mt-2 text-zinc-500 dark:text-zinc-400">
                    {{ __("You're about to delete this project. This action cannot be reversed.") }}
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost" class="cursor-pointer">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>
                <flux:button wire:click="deleteProject" type="submit" variant="danger" class="cursor-pointer">
                    {{ __('Delete project') }}
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
