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
            {{-- <div class="bg-white shadow rounded-lg p-6 mb-6">

                <div class="flex justify-between items-center mb-4">

                    <h3 class="text-lg font-bold">
                        Notes
                    </h3>

                    <a href="#" class="bg-green-600 text-white px-4 py-2 rounded">
                        Add Note
                    </a>

                </div>

                @if($lead->leadNotes->count())

                    @foreach($lead->leadNotes as $note)

                        {{ $note->note }}

                        {{ $note->user->name }}

                        {{ $note->created_at->diffForHumans() }}

                    @endforeach

                @else

                No Notes

                @endif

            </div> --}}

            <!-- Notes -->

            <div class="bg-white shadow rounded-lg p-6 mb-6">

                <h3 class="text-lg font-bold mb-4">
                    Notes
                </h3>

                <form method="POST"
                    action="{{ route('lead-notes.store') }}">

                    @csrf

                    <input
                        type="hidden"
                        name="lead_id"
                        value="{{ $lead->id }}">

                    <textarea
                        name="note"
                        rows="3"
                        class="w-full border rounded p-3"
                        placeholder="Write your note..."></textarea>

                    <button
                        class="mt-3 bg-green-600 text-white px-4 py-2 rounded">

                        Add Note

                    </button>

                </form>

                <hr class="my-5">

                <div class="grid grid-cols-2 gap-4">
                    @forelse($lead->leadNotes as $note)

                        <div class="border rounded p-4 mb-4">

                            <div id="view-{{ $note->id }}">

                                <div class="mt-2 text-gray-700">
                                    {{ $note->note }}
                                </div>

                                <div class="mt-3 flex gap-4">

                                    <button
                                        type="button"
                                        onclick="editNote({{ $note->id }})"
                                        class="text-blue-600">

                                        Edit

                                    </button>

                                    <form
                                        method="POST"
                                        action="{{ route('lead-notes.destroy',$note) }}">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="text-red-600">

                                            Delete

                                        </button>

                                    </form>

                                </div>

                            </div>
                            <div
                                id="edit-{{ $note->id }}"
                                class="hidden">

                                <form
                                    method="POST"
                                    action="{{ route('lead-notes.update',$note) }}">

                                    @csrf
                                    @method('PUT')

                                    <textarea
                                        name="note"
                                        rows="3"
                                        class="w-full border rounded p-2">{{ $note->note }}</textarea>

                                    <div class="mt-3">

                                        <button
                                            class="bg-blue-600 text-white px-3 py-1 rounded">

                                            Save

                                        </button>

                                        <button
                                            type="button"
                                            onclick="cancelEdit({{ $note->id }})"
                                            class="bg-gray-500 text-white px-3 py-1 rounded ml-2">

                                            Cancel

                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    @empty

                        <p class="text-gray-500">
                            No Notes Yet.
                        </p>

                    @endforelse
                </div>

            </div>

            <!-- Follow Ups -->

            <div class="bg-white shadow rounded-lg p-6 mb-6">

                <div class="flex justify-between items-center mb-4">

                    <h3 class="text-lg font-bold">
                        Follow Ups
                    </h3>

                   <a  href="{{ route('follow-ups.create', ['lead' => $lead->id]) }}"
                    class="bg-indigo-600 text-white px-4 py-2 rounded">

                    Add Follow Up

                </a>

                </div>

                @forelse($lead->followUps as $followUp)

                    <div class="border rounded-lg p-4 mb-3">

                        <div class="flex justify-between">

                            <div>

                                <p class="font-semibold">

                                    {{ $followUp->follow_up_date }}

                                    @if($followUp->follow_up_time)

                                        {{ $followUp->follow_up_time }}

                                    @endif

                                </p>

                                <p class="text-gray-600 mt-2">

                                    {{ $followUp->remarks }}

                                </p>

                            </div>

                            {{-- <div>

                                @if($followUp->status == 'Pending')

                                    <span class="bg-yellow-500 text-white px-3 py-1 rounded">
                                        Pending
                                    </span>

                                @elseif($followUp->status == 'Completed')

                                    <span class="bg-green-600 text-white px-3 py-1 rounded">
                                        Completed
                                    </span>

                                @else

                                    <span class="bg-red-600 text-white px-3 py-1 rounded">
                                        Missed
                                    </span>

                                @endif

                            </div> --}}
                            <div class="flex flex-col items-end gap-2">

                                @if($followUp->status == 'Pending')

                                    <span
                                        class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">

                                        Pending

                                    </span>

                                @elseif($followUp->status == 'Completed')

                                    <span
                                        class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">

                                        Completed

                                    </span>

                                @else

                                    <span
                                        class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">

                                        Missed

                                    </span>

                                @endif
                                 {{-- Priority Badge --}}
                                @if($followUp->priority == 'High')

                                    <span class="px-3 py-1 text-xs rounded-full bg-red-600 text-white">
                                        High
                                    </span>

                                @elseif($followUp->priority == 'Medium')

                                    <span class="px-3 py-1 text-xs rounded-full bg-yellow-500 text-white">
                                        Medium
                                    </span>

                                @else

                                    <span class="px-3 py-1 text-xs rounded-full bg-green-600 text-white">
                                        Low
                                    </span>

                                @endif

                            </div>

                        </div>

                        <div class="text-sm text-gray-500 mt-3">

                            By:
                            {{ $followUp->user->name }}

                        </div>

                    </div>

                @empty

                    <div class="text-gray-500">

                        No Follow Ups Found.

                    </div>

                @endforelse

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
<script>

function editNote(id)
{
    document
        .getElementById('view-'+id)
        .classList.add('hidden');

    document
        .getElementById('edit-'+id)
        .classList.remove('hidden');
}

function cancelEdit(id)
{
    document
        .getElementById('edit-'+id)
        .classList.add('hidden');

    document
        .getElementById('view-'+id)
        .classList.remove('hidden');
}

</script>
</x-app-layout>
