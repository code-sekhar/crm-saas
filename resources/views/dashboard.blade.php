{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            CRM Dashboard
        </h2>
    </x-slot>
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <p class="text-sm text-gray-500">Total Leads</p>
                    <h3 class="text-3xl font-bold mt-2">
                        {{ $totalLeads ?? 0 }}
                    </h3>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <p class="text-sm text-gray-500">Today's Leads</p>
                    <h3 class="text-3xl font-bold mt-2">
                        {{ $todayLeads ?? 0 }}
                    </h3>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <p class="text-sm text-gray-500">Won Leads</p>
                    <h3 class="text-3xl font-bold mt-2 text-green-600">
                        {{ $wonLeads ?? 0 }}
                    </h3>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <p class="text-sm text-gray-500">Lost Leads</p>
                    <h3 class="text-3xl font-bold mt-2 text-red-600">
                        {{ $lostLeads ?? 0 }}
                    </h3>
                </div>
            </div>

        </div>

        <!-- Recent Leads -->
        <div class="bg-white shadow rounded-lg">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold">
                    Recent Leads
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Name
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Email
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Source
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Status
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">

                        @forelse($recentLeads ?? [] as $lead)

                            <tr>
                                <td class="px-6 py-4">
                                    {{ $lead->name }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $lead->email }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $lead->source }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $lead->status }}
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    No leads found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>

</x-app-layout>
