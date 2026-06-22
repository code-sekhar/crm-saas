<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl">
        Leads
    </h2>
</x-slot>

<div class="py-6">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow rounded-lg">

            <div class="p-6">

                <div class="flex justify-between mb-4">

                    <h3 class="text-lg font-bold">
                        All Leads
                    </h3>

                    <a href="/leads/create"
                       class="px-4 py-2 bg-blue-600 text-white rounded">
                        Add Lead
                    </a>

                </div>

                <table class="w-full border">

                    <thead>

                    <tr class="bg-gray-100">

                        <th class="p-3 border">ID</th>
                        <th class="p-3 border">Name</th>
                        <th class="p-3 border">Email</th>
                        <th class="p-3 border">Phone</th>
                        <th class="p-3 border">Source</th>
                        <th class="p-3 border">Status</th>
                        <th>Action</th>

                    </tr>

                    </thead>

                    <tbody>

                    @foreach($leads as $lead)

                        <tr>

                            <td class="border p-2">
                                {{ $lead->id }}
                            </td>

                            <td class="border p-2">
                                {{ $lead->name }}
                            </td>

                            <td class="border p-2">
                                {{ $lead->email }}
                            </td>

                            <td class="border p-2">
                                {{ $lead->phone }}
                            </td>

                            <td class="border p-2">
                                {{ $lead->source }}
                            </td>

                            <td class="border p-2">
                                {{ $lead->status }}
                            </td>
                            <td class="border p-2 d-flex gap-2 justify-content-center">
                                <a href="{{ route('leads.edit',$lead) }}" style="
    width: 20px !important;
    display: flex;
    float: left;
">
                                    <x-bxs-edit />
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('leads.destroy',$lead) }}"
                                    style="display:inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" style="
    width: 20px !important;
    display: flex;
">
                                        <x-ri-delete-bin-4-fill />
                                    </button>

                                </form>
                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


</x-app-layout>
