<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-5">
                                {{ __('Create Task') }}
                            </h2>
                        </header>
                        
                        <form method="POST" action="{{ route('task.store') }}">
                            @csrf
                            
                            @if (@session('status')):
                                <p class="mt-2 text-sm text-green-600 dark:text-green-500"><span class="font-medium">{{ session('status') }}</span></p>
                            @endif
                            
                            
                            <!-- Project Id -->
                            <div>
                                <label for="project_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Project Name') }}</label>
                                <select id="project_id" name="project_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected value="">Choose a project</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }} {{ (old("project_id") == $project->id ? "selected":"") }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                                
                                <x-input-error :messages="$errors->get('project_id')" class="mt-2" />
                            </div>
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Name')"  class="mt-5"/>
                                <x-text-input placeholder="Task name" id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div>
                                <x-input-label for="description" :value="__('Description')" class="mt-5" />
                                <textarea id="description" rows="4" class="block mt-1 w-full p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Task description" name="description">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                            <div class="flex items-center justify-end mt-4">
                
                                <x-primary-button class="ms-4">
                                    {{ __('Created') }}
                                </x-primary-button>
                            </div>
                        </form>

                    </section>
                    
                </div>
            </div>

        </div>
    </div>

    <div class="py-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('List Tasks') }} ({{ $total }})
                        </h2>
                    </header>

                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Project Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Task
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Description
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Date Start  
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        user
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Hours Pass
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $task->project->name }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $task->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $task->description }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($task->start_date)
                                                {{ \Carbon\Carbon::parse($task->start_date)->format('d/m/Y')}}
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $task->user->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($task->start_date)
                                                {{ \Carbon\Carbon::create($task->start_date)->diffForHumans(\Carbon\Carbon::now()) }}
                                            @else
                                                --
                                            @endif
                                        </td>
                                        
                                        @can('update', $task)
                                            <td class="px-6 py-4">
                                                @if(!$task->start_date)
                                                    <a href="{{  route('task.start', $task->id) }}" class="inline-block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">Start</a>
                                                @else
                                                    <a href="{{  route('task.stop', $task->id) }}" class="inline-block text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-yellow-600 dark:hover:bg-yellow-700 focus:outline-none dark:focus:ring-yellow-800">Stop</a>
                                                @endif
                                                <a href="{{  route('task.edit', $task) }}" class="inline-block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Edit</a>
                                                
                                                <form action="{{ route('task.destroy', $task->id) }}" method="POST">
                                                    @csrf @method('delete')
                                                    
                                                    <a :href="{{  route('task.edit', $task->id) }}" class="inline-block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800" onclick="event.preventDefault(); this.closest('form').submit();">Delete</a>
                                                </form>
                                        </td>
                                        @endcan
                                    </tr>
                                
                                    
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>