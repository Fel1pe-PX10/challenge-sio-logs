<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('How to works!') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("How to use:") }}
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("- Projects:") }}
                    <p>In section <x-nav-link :href="route('projects.create')">Projects</x-nav-link> it is possible to create a project and estimate the number of hours that need it.</p>
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("- Task:") }}
                    <p>In section <x-nav-link :href="route('tasks.create')">Task</x-nav-link> it is possible to create a task. This should be related to a project (Created previously), In the above part it is possible to check the task to start, finish, edit or delete it.</p>
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("- Dashboard:") }}
                    <p>The <x-nav-link :href="route('logs.show')">Dashboard</x-nav-link> section has 4 tables:</p>
                    <p>The first one shows the summary of the projects, if there are more than freelance working in the same project, this table shows the sum of the total hours.</p>
                    <p>The second and third ones show the sum of hours for the freelancer login currently, separate it for weekdays and months.</p>
                    <p>The last one shows the table with information task for the current session freelancer, it is possible to edit, start, stop or delete the task.</p>
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("- Note:") }}
                    <p>- If the task has been started, only it is possible to stop it through the button.</p>
                    <p>- If the task has never been started, only will enable the start button.</p>
                    <p>- When the task is editing, it is possible to start or to finish it with a checkbox, and if the task is finished, the user could change the dates throughout the date fields</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
