<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lead Details
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Lead Information -->
            <div class="bg-white shadow rounded-lg p-6 mb-6">

                <h3 class="text-lg font-bold mb-6 border-b pb-3">
                    Lead Information
                </h3>

                <div class="grid grid-cols-2 gap-6">

                    <div>
                        <p class="text-gray-500 text-sm">Name</p>
                        <p class="font-semibold">{{ $lead->name }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Email</p>
                        <p>{{ $lead->email }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Phone</p>
                        <p>{{ $lead->phone }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Source</p>
                        <p>{{ $lead->source }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Status</p>

                        <span class="px-3 py-1 rounded bg-blue-500 text-white">
                            {{ $lead->status }}
                        </span>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Created At</p>
                        <p>{{ $lead->created_at->format('d M Y h:i A') }}</p>
                    </div>

                </div>

            </div>

            <!-- Tasks -->
            <div class="bg-white shadow rounded-lg p-6 mb-6">

                <div class="flex justify-between items-center mb-4">

                    <h3 class="text-lg font-bold">
                        Tasks
                    </h3>

                    <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded">
                        Add Task
                    </a>

                </div>
                @if($lead->tasks->count())

                <table class="w-full border">

                    <thead>

                    <tr>

                        <th class="border p-2">
                            Title
                        </th>

                        <th class="border p-2">
                            Due Date
                        </th>

                        <th class="border p-2">
                            Status
                        </th>

                    </tr>

                    </thead>

                    <tbody>

                    @foreach($lead->tasks as $task)

                    <tr>

                        <td class="border p-2">
                            {{ $task->title }}
                        </td>

                        <td class="border p-2">
                            {{ $task->due_date }}
                        </td>

                        <td class="border p-2">
                            {{ $task->status }}
                        </td>

                    </tr>

                    @endforeach

                    </tbody>

                </table>

                @else

                <p class="text-gray-500">
                    No tasks available.
                </p>

                @endif


            </div>

            <!-- Notes -->
            <div class="bg-white shadow rounded-lg p-6 mb-6">

                <div class="flex justify-between items-center mb-4">

                    <h3 class="text-lg font-bold">
                        Notes
                    </h3>

                    <a href="#" class="bg-green-600 text-white px-4 py-2 rounded">
                        Add Note
                    </a>

                </div>

                <p class="text-gray-500">
                    No notes available.
                </p>

            </div>

            <!-- Activity -->
            <div class="bg-white shadow rounded-lg p-6">

                <h3 class="text-lg font-bold mb-4">
                    Activity Timeline
                </h3>

                <ul class="space-y-3">

                    <li class="border-l-4 border-blue-500 pl-4">
                        Lead Created
                    </li>

                </ul>

            </div>

        </div>
    </div>

</x-app-layout>
