<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-right text-gray-800 leading-tight">
            לקוח חדש
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container p-2 mx-auto sm:p-4 text-gray-800">
                    <div class="overflow-x-auto">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <span class="flex justify-end items-center text-right font-medium tracking-wide text-red-500 text-md mt-1 ml-1">{{ $error }}</span>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('page.clients.store') }}">
                            @csrf
                            <div class="flex flex-wrap flex-row-reverse mb-4">
                                <div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/2 xl:w-1/2 mb-2 px-2">
                                    <x-jet-label for="name" class="text-right" value="שם מלא"/>
                                    <x-jet-input id="name" class="block mt-1 w-full text-right" type="text" name="name"
                                                 :value="old('name')"  autofocus required autocomplete="name"/>
                                    {!! $errors->first('name', '<span class="flex items-center text-right font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">שדה חובה</span>') !!}

                                </div>
                                <div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/2 xl:w-1/2 mb-2 px-2">
                                    <x-jet-label for="email" class="text-right" value='דוא״ל'/>
                                    <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email"
                                                 :value="old('email')" required/>
                                </div>

                                <div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/2 xl:w-1/2 mb-2 px-2">
                                    <x-jet-label for="adwords_id" class="text-right" value="Adwords ID"/>
                                    <x-jet-input id="adwords_id" class="block mt-1 w-full" type="text" name="adwords_id"
                                                 :value="old('adwords_id')" required/>
                                    {!! $errors->first('adwords_id', '<span class="flex items-center text-right font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">:message</span>') !!}
                                </div>

                                <div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/2 xl:w-1/2 mb-2 px-2">
                                    <x-jet-label for="password" class="text-right" value="סיסמא"/>
                                    <x-jet-input id="password" class="block mt-1 w-full bg-gray-50 opacity-75 pointer-events-none"
                                                 type="text" name="password" value="{{ Str::random(16) }}" required
                                                 />
                                </div>

                            </div>


                            <div class="flex items-center justify-end mt-4">
                                <x-jet-button class="ml-4">
                                    שמור
                                </x-jet-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
