<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl">
        Create Task
    </h2>
</x-slot>

<div class="py-6">
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    <div class="bg-white shadow rounded p-6">

        <form method="POST"
              action="{{ route('tasks.store') }}">

            @csrf

            <div class="mb-4">
                <label>Title</label>

                <input type="text"
                       name="title"
                       class="w-full border rounded p-2"
                       required>
            </div>

            <div class="mb-4">
                <label>Description</label>

                <textarea
                    name="description"
                    class="w-full border rounded p-2"></textarea>
            </div>

            <div class="mb-4">
                <label>Due Date</label>

                <input type="date"
                       name="due_date"
                       class="w-full border rounded p-2">
            </div>

            <button
                type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded">

                Save Task

            </button>

        </form>

    </div>

</div>
</div>

</x-app-layout>
