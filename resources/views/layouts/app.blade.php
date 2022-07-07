<!DOCTYPE html>
<html data-theme="winter" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Hebrew:wght@100;300;400;700&display=swap"
          rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    @livewireStyles

    <!-- Scripts -->
    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body class="font-sans antialiased" dir="rtl">
<x-jet-banner/>

<div class="min-h-screen bg-gray-100">
    @livewire('navigation-menu')
    <div class="w-full">
        <div class="flex flex-row py-4 w-full">
            <aside class="w-60" aria-label="Sidebar">
                <div class="overflow-y-auto py-4 px-3 bg-gray-50 rounded dark:bg-gray-800">
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('dashboard') }}"
                               class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg
                                    class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                    <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                                </svg>
                                <span class="mr-3">מסך ראשי</span>
                            </a>
                        </li>
                        <li>
                            <button type="button"
                                    class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                    aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                                <svg
                                    class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                                          clip-rule="evenodd"></path>
                                </svg>
                                <span class="flex-1 mr-3 text-left whitespace-nowrap text-right" sidebar-toggle-item>נתונים</span>
                                <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <ul id="dropdown-example" class="hidden py-2 space-y-2">
                                <li>
                                    <a href="{{ route('stats.account') }}"
                                       class="loading-ev flex items-center p-2 pr-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">ביצועי
                                        חשבון</a>
                                </li>
                                <li>
                                    <a href="{{ route('stats.keywords') }}"
                                       class="loading-ev flex items-center p-2 pr-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">מילות
                                        מפתח</a>
                                </li>
                                <li>
                                    <a href="{{ route('stats.calls') }}"
                                       class="loading-ev flex items-center p-2 pr-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">שיחות</a>
                                </li>
                            </ul>
                        </li>
                        @if(Auth::user()->role === 'super_admin' || Auth::user()->role === 'manager')
                            <li>
                                <button type="button"
                                        class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                        aria-controls="clients-nav" data-collapse-toggle="clients-nav">
                                    <svg
                                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                              d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="flex-1 mr-3 text-left whitespace-nowrap text-right"
                                          sidebar-toggle-item>לקוחות</span>
                                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <ul id="clients-nav" class="hidden py-2 space-y-2">
                                    <li>
                                        <a href="{{ route('page.clients') }}"
                                           class="loading-ev flex items-center p-2 pr-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">כל
                                            הלקוחות</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('page.clients.add') }}"
                                           class="loading-ev flex items-center p-2 pr-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                            לקוח חדש</a>
                                    </li>
                                </ul>


                            </li>
                        @endif
                    </ul>
                </div>
            </aside>
            <main class="grow">
                @if (session()->has('message'))
                    <div
                        class="p-4 mb-4 text-sm text-center text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                        role="alert">
                        {{ session('message') }}
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>
    </div>


</div>

@stack('modals')

@livewireScripts
</body>

<div class="loader-container fixed left-0 top-0 w-full h-full bg-white" id="loader-container">

    <svg class="loader" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 340 340">
        <circle cx="170" cy="170" r="160" stroke="#E2007C"/>
        <circle cx="170" cy="170" r="135" stroke="#404041"/>
        <circle cx="170" cy="170" r="110" stroke="#E2007C"/>
        <circle cx="170" cy="170" r="85" stroke="#404041"/>
    </svg>

</div>

</html>
