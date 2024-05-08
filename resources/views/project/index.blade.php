<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('projects.store') }}">
                        @csrf
            
                        <!-- Name -->
                        <div>
                            @if (@session('status'))
                                <p class="mt-2 text-sm text-green-600 dark:text-green-500"><span class="font-medium">{{ session('status') }}</span></p>
                            @endif
                            <div>
                                <x-input-label for="name" :value="__('Project Name')" />
                                <x-text-input placeholder="Project name" id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="mt-5">
                                <x-input-label class="mt-5" for="name" :value="__('Project Hours Estimated')" />
                                <x-text-input placeholder="Project hours" id="hours_estimated" class="block mt-1 w-full" type="number" name="hours_estimated" :value="old('hours_estimated')" required autofocus autocomplete="hours_estimate" />
                                <x-input-error :messages="$errors->get('hours_estimated')" class="mt-2" />
                            </div>
                        </div>
            
                        <div class="flex items-center justify-end mt-4">
            
                            <x-primary-button class="ms-4">
                                {{ __('Created') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
