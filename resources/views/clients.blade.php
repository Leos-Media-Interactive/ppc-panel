<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-right text-gray-800 leading-tight">
            לקוחות
        </h2>
    </x-slot>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jstable.css') }}" >
    <script type="text/javascript" src="{{ asset('js/jstable.js') }}"></script>

    <div class="py-12">
        <div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container p-2 mx-auto sm:p-4 text-gray-800">
                    <div class="flex justify-end">
                        <a href="{{ route('page.clients.add') }}" class="border border-indigo-500 bg-indigo-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-indigo-600 focus:outline-none focus:shadow-outline">
                            לקוח חדש
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-xs text-right w:100" id="clients" style="direction: rtl">
                            <colgroup>
                                <col>
                                <col>
                                <col>
                                <col>
                                <col>
                                <col class="w-24">
                            </colgroup>
                            <thead class="bg-gray-300">
                            <tr class="text-right">
                                <th class="p-3">#</th>
                                <th class="p-3 text-right">
                                    <p class="text-right">שם</p>
                                </th>
                                <th class="p-3">
                                    <p class="text-center">Adwords ID</p>
                                </th>
                                <th class="p-3">
                                    <p class="text-center">E-mail</p>
                                </th>
                                <th class="p-3">
                                    <p class="text-center">Role</p>
                                </th>
                                <th class="p-3">
                                    <p class="text-center">כניסה אחרונה</p>
                                </th>
                                <th class="p-3">
                                    <p class="text-center">תאריך יצירה</p>
                                </th>
                                <th class="p-3">
                                    <p class="text-center">פעולות</p>
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            <p>
                                ID: {{ session('client_id') }}
                            </p>
                            @foreach($clients as $client)
                                <tr class="border-b border-opacity-20 border-gray-300  {{ $client->role === 'manager' ? 'bg-indigo-300' : 'bg-gray-50' }}">

                                    <td class="p-3">
                                        <p>{{ $client->id }}</p>
                                    </td>

                                    <td class="p-3">
                                        <p>{{ $client->name }}</p>
                                    </td>
                                    <td class="p-3">
                                        <p class="text-center">{{ $client->adwords_id }}</p>
                                    </td>
                                    <td class="p-3">
                                        <p class="text-center">{{ $client->email }}</p>
                                    </td>
                                    <td class="p-3">
                                        <p class="text-center">{{ $client->role }}</p>
                                    </td>
                                    <td class="p-3">
                                        <p></p>
                                    </td>
                                    <td class="p-3">
                                        <p class="text-center">{{ $client->created_at }}</p>
                                    </td>
                                    <td class="p-3 text-right flex justify-center">
                                        <a href="{{ route('page.clients.edit', ['id' => $client->id]) }}">
                                            <x-antdesign-edit-o class="w-5 mr-1"/>
                                        </a>

                                        <a href="{{ route('password.reset', $client->id) }}" title="איפוס סיסמא">
                                            <x-fontisto-random class="w-5 mr-1"/>
                                        </a>

                                        <a href="{{ route('load-id', $client->id) }}">
                                            <x-akar-statistic-up class="w-5 mr-1"/>
                                        </a>

                                        <script type="text/javascript">
                                            function confirm_alert(node) {
                                                return confirm("למחוק לקוח ?");
                                            }
                                        </script>
                                        <a href="{{ route('page.clients.delete', ['id' => $client->id]) }}" onclick="return confirm_alert(this);">
                                            <x-antdesign-close-square class="w-5 mr-1" />
                                        </a>

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
    <script>
        let myTable = new JSTable("#clients", {
            sortable: true,
            searchable: true,
            perPage: 100,
            perPageSelect: false,
            labels: {
                placeholder: "חיפוש...",
                perPage: "entries per page",
                noRows: "No entries found",
                info: "Showing {start} to {end} of {rows} entries",
                loading: "Loading...",
                infoFiltered: "Showing {start} to {end} of {rows} entries (filtered from {rowsTotal} entries)"
            },
            classes: {
                top: "justify-end mb-2",
                info: "dt-info",
                input: "dt-input",
                table: "dt-table",
                bottom: "dt-bottom",
                search: "dt-search justify-end flex",
                sorter: "dt-sorter",
                wrapper: "dt-wrapper",
                dropdown: "dt-dropdown",
                ellipsis: "dt-ellipsis",
                selector: "dt-selector",
                container: "dt-container",
                pagination: "dt-pagination",
                loading: "dt-loading",
                message: "dt-message"
            }
        });
    </script>
</x-app-layout>
