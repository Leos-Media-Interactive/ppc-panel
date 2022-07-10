<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-right text-gray-800 leading-tight">
            שיחות
        </h2>
    </x-slot>

    <div class="mx-auto sm:px-6 lg:px-8 flex">
        <div class="bg-white w-full grow shadow-xl mx-2 sm:rounded-lg">
            <div class="container p-2 mx-auto sm:p-4 text-gray-800 relative">

                <x-jet-range-controller content="{{ route('stats.calls') }}" range="{{ $selected_range }}" />

                @if($calls)
                    <table class="table table-zebra w-full">
                        <!-- head -->
                        <thead>
                        <tr class="text-center">
                            <th>תאריך ושעה</th>
                            <th>קבוצת מודעות</th>
                            <th>דרך התקשרות</th>
                            <th>סטטוס שיחה</th>
                            <th>משך שיחה בשניות</th>
                            <th>קידומת</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($calls as $_call)
                            <tr class="text-center">
                                <td>{{ $_call['call_entry']['start_call_date_time'] }}</td>
                                <td>{{ $_call['ad_group']['name'] }}</td>
                                <td class="flex justify-center">{{ svg($_call['call_entry']['type'], 'w-6 h-6') }}</td>
                                <td>{!! $_call['call_entry']['call_status'] !!}</td>
                                <td>{{ $_call['call_entry']['call_duration_seconds'] }}</td>
                                <td>{{ $_call['call_entry']['caller_country_code'] }}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
