<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- Summary projects --}}
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-5">
                            {{ __('Summary Projects with finished tasks') }}
                        </h2>
                    </header>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Project name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Project hours 
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Working Hours 
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        % hours/work
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects as $project)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $project->name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $project->hours_estimated }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $project->difference }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ round(($project->difference/$project->hours_estimated*100),2) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Summary week --}}
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-5">
                            {{ __('Summary hours per weekdays') }}
                        </h2>
                    </header>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Day of week
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Working hours 
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($weekdays as $weekday)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $weekday->day }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $weekday->difference }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Summary task --}}
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-5">
                            {{ __('Summary hours per task') }}
                        </h2>
                    </header>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Month of year
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Working hours 
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($months as $month)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $month->month_year }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $month->difference }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Summary tasks --}}
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-5">
                            {{ __('Logs Finished Tasks') }}
                        </h2>
                    </header>
                    <div class="relative overflow-x-auto">
                        <a href="{{  route('logs.exportCsv') }}" class="inline-block mb-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Download CSV</a>
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
                                        Start date  
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                         Stop date
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
                                            {{ $task->projectName }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $task->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $task->description }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $task->start }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $task->stop }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $task->userName }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $task->difference }}
                                        </td>
                                        
                                        @if(auth()->user()->id == $task->userId)
                                            <td class="px-6 py-4">
                                                @if(!$task->start)
                                                    <a href="{{  route('tasks.start', $task->id) }}" class="inline-block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">Start</a>
                                                @elseif(!$task->stop)
                                                    <a href="{{  route('tasks.stop', $task->id) }}" class="inline-block text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-yellow-600 dark:hover:bg-yellow-700 focus:outline-none dark:focus:ring-yellow-800">Stop</a>
                                                @endif
                                                <a href="{{  route('tasks.edit', $task->id) }}" class="inline-block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Edit</a>
                                                
                                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                                    @csrf @method('delete')
                                                    
                                                    <a :href="{{  route('tasks.edit', $task->id) }}" class="inline-block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800" onclick="event.preventDefault(); this.closest('form').submit();">Delete</a>
                                                </form>
                                        </td>
                                        @endif   
                                    </tr>
                                
                                    
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
