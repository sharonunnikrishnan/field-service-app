<flux:modal name="project-modal"
    class="!max-w-none w-[calc(100vw-1rem)] sm:w-[calc(100vw-2rem)] max-h-[calc(100dvh-1rem)] sm:max-h-[calc(100dvh-2rem)] m-2 sm:m-4 my-2 sm:my-4 mx-2 sm:mx-4 p-4 sm:p-6 lg:p-8 overflow-y-auto rounded-2xl">
    <form wire:submit="saveProject" class="space-y-6">
        {{-- Modal Header --}}
        <div class="border-b border-zinc-100 dark:border-zinc-700/80 pb-4 pr-10">
            <flux:heading class="font-bold text-zinc-900 dark:text-white" size="xl">
                {{ $isView ? __('Project Details') : ($projectId ? __('Update Project') : __('Create Project')) }}
            </flux:heading>
            <flux:subheading size="base" class="mt-1 text-zinc-500 dark:text-zinc-400">
                {{ $isView ? __('View full information about this project') : ($projectId ? __('Modify existing project information') : __('Fill in the fields below to add a new project')) }}
            </flux:subheading>
        </div>

        {{-- Form Fields: Responsive Multiple Columns on Desktop --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-6">
            {{-- Project Name --}}
            <div class="form-group col-span-1">
                <flux:input :disabled="$isView" wire:model="name" label="{{ __('Project Name') }}"
                    placeholder="Enter project name" />
            </div>

            {{-- Status --}}
            <div class="form-group col-span-1">
                <flux:select :disabled="$isView" wire:model="status" label="{{ __('Status') }}"
                    placeholder="Select Status...">
                    <flux:select.option value="pending">Pending</flux:select.option>
                    <flux:select.option value="in-progress">In-Progress</flux:select.option>
                    <flux:select.option value="completed">Completed</flux:select.option>
                    <flux:select.option value="cancelled">Cancelled</flux:select.option>
                </flux:select>
            </div>

            {{-- Deadline --}}
            <div class="form-group col-span-1">
                <flux:input :disabled="$isView" wire:model="deadline" type="date" label="{{ __('Deadline') }}" />
            </div>

            {{-- Description (Spans 2 columns on lg desktop, 2 columns on md) --}}
            <div class="form-group col-span-1 md:col-span-2 lg:col-span-2">
                <flux:textarea :disabled="$isView" wire:model="description" label="{{ __('Description') }}"
                    placeholder="Enter a detailed project description..." rows="4" />
            </div>

            {{-- Project Logo (Col 3 on lg desktop, Col 1 on md) --}}
            <div class="form-group col-span-1 md:col-span-2 lg:col-span-1">
                @if (!$isView)
                    <flux:input wire:model="project_logo" type="file" class="cursor-pointer" label="{{ __('Project Logo') }}"
                        accept="image/*" />
                @else
                    <flux:label>{{ __('Project Logo') }}</flux:label>
                @endif

                <div class="mt-2.5">
                    @if ($project_logo && !$errors->has('project_logo'))
                        <div class="flex items-center gap-3 p-2.5 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50">
                            <img src="{{ $project_logo->temporaryUrl() }}" class="h-16 w-24 object-cover rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-2xs" />
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                <span class="font-medium text-emerald-600 dark:text-emerald-400">New logo selected</span>
                                <div class="text-[11px] text-zinc-400">Ready to upload on save</div>
                            </div>
                        </div>
                    @elseif ($projectId && $existingImage)
                        <div class="flex items-center gap-3 p-2.5 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50">
                            <img src="{{ asset('storage/' . $existingImage) }}" class="h-16 w-24 object-cover rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-2xs" />
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                <span class="font-medium text-zinc-700 dark:text-zinc-300">Current logo</span>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-2 p-3 rounded-xl border border-dashed border-zinc-200 dark:border-zinc-700 text-xs text-zinc-400 dark:text-zinc-500">
                            <flux:icon.photo class="size-4 opacity-50 shrink-0" />
                            <span>No logo uploaded yet</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-100 dark:border-zinc-700/80">
            <flux:modal.close>
                <flux:button variant="ghost" class="cursor-pointer">{{ __('Cancel') }}</flux:button>
            </flux:modal.close>

            @if (!$isView)
                <flux:button type="submit" variant="primary" color="lime" class="cursor-pointer shadow-sm">
                    {{ $projectId ? __('Update Project') : __('Save Project') }}
                </flux:button>
            @endif
        </div>
    </form>
</flux:modal>
