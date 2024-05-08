<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    
                    <section>

                
                    
                        <form method="POST" action="{{ route('tasks.update', $task->id) }}">
                            @csrf @method('PUT')
                
                            @if (@session('status'))
                                <p class="mt-2 text-sm text-green-600 dark:text-green-500"><span class="font-medium">{{ session('status') }}</span></p>
                            @endif
                            <!-- Id -->
                            <div>
                                <label for="project_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Project Name') }}</label>
                                <select id="project_id" name="project_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected value="">Choose a country</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}" {{ (old('project_id', $task->project_id) == $project->id ? "selected":"") }}>{{ $project->name }}</option>
                                    @endforeach
                                </select>
                                
                                <x-input-error :messages="$errors->get('project_id')" class="mt-2" />
                            </div>
                            
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Name')"  class="mt-5"/>
                                <x-text-input placeholder="Task name" id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $task->name)" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div>
                                <x-input-label for="description" :value="__('Description')" class="mt-5" />
                                <textarea id="description" rows="4" class="block mt-1 w-full p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Task description" name="description">{{ old('name', $task->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                            
                            <!-- Date start -->
                            @if($task->start_date)
                                <div>
                                    <x-input-label for="name" :value="__('Start')"  class="mt-5"/>
                                    <input
                                        type="datetime-local"
                                        id="start_date"
                                        name="start_date"
                                        value="{{ $task->start_date }}"/>
                                    {{-- <x-text-input placeholder="Task starts" id="start_date" class="block mt-1 w-full" type="text" name="start_date" :value="old('start_date', $task->start_date)" required autofocus autocomplete="start_date" /> --}}
                                    <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                                </div>
                                
                                <!-- Checkbox stop -->
                                <div class="flex items-center mb-4 mt-5">
                                    <input id="stop_date" name="stop_date" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="default-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Finish task</label>
                                </div>
                            @else
                                <!-- Checkbox start -->
                                <div class="flex items-center mb-4 mt-5">
                                    <input id="start_date" name="start_date" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="default-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Start task</label>
                                </div>
                            @endif
                            
                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button class="ms-4">
                                    {{ __('Edited') }}
                                </x-primary-button>
                            </div>
                        </form>

                    </section>
                    
                </div>
            </div>

        </div>
    </div>
</x-app-layout>