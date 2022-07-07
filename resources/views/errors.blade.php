<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-right text-gray-800 leading-tight">
            שגיאה
        </h2>
    </x-slot>

    <div class="mx-auto sm:px-6 lg:px-8 flex">
        <div class="bg-white w-full grow shadow-xl mx-2 sm:rounded-lg">
            <div class="container p-2 mx-auto sm:p-4 text-gray-800 relative">
                @if($errors['type'] === 'ApiException')
                    <div class="alert alert-error shadow-lg">
                        <div class="flex flex-col text-left" style="direction: ltr">
                            <h2>Status: {{ $errors['status'] }}</h2>
                            <h2>Title: {{ $errors['title'] }}</h2>
                            <ul class="border border-r-base-300 p-2">
                                @foreach ($errors['meta'] as $key => $value)
                                    <li>
                                        Key: {{ $key }}
                                        <br>
                                        <span style="direction: ltr">
                                            Value: {{ var_dump($value) }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
