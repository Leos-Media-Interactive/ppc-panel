<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-right text-gray-800 leading-tight">
            נתוני פרסום
        </h2>
    </x-slot>

    <div class="mx-auto sm:px-6 lg:px-8 flex">
        <div class="bg-white w-4/5 grow shadow-xl mx-2 sm:rounded-lg">
            <div class="container p-2 mx-auto sm:p-4 text-gray-800 relative">

                @foreach($account_performance['ad_rows'] as $_c)
                    <div class="cmp-canvas  @if ($loop->first) active-canvas @endif left-0 top-0 w-full h-full"
                         id="cmp-{{ $_c['ad_group']['id'] }}">
                        <div class="card-body">
                            <div class="alert alert-info shadow-lg">
                                <h2 class="text-right text-lg text-black">{{ $_c['ad_group']['name'] }}</h2>
                            </div>
                        </div>

                        <div class="card-body" style="direction: ltr">
                            <div class="stats shadow text-right">
                                <div class="stat flex flex-col justify-between">
                                    <div class="stat-title">קליקים</div>
                                    <div class="stat-value">{{ $_c['metrics']['clicks']  }}</div>
                                </div>

                                <div class="stat flex">
                                    <div class="grow flex flex-col justify-between">
                                        <div class="stat-title ">שעיור קליקים</div>
                                        <div class="stat-value">{{ round($_c['metrics']['ctr'] * 100, 1)  }}%</div>
                                    </div>
                                    <div class="">
                                        <div
                                            class="radial-progress bg-gray-400 text-primary-content border-4 border-primary"
                                            style="--value:{{ round($_c['metrics']['ctr'] * 100)  }};">
                                            {{ round($_c['metrics']['ctr'] * 100, 1)  }}%
                                        </div>
                                    </div>
                                </div>

                                <div class="stat flex flex-col justify-between">
                                    <div class="stat-title"> המרות</div>
                                    <div class="stat-value">{{ round($_c['metrics']['conversions']) }}</div>
                                </div>

                                <div class="stat flex">
                                    <div class="grow flex flex-col justify-between">
                                        <div class="stat-title ">שעיור המרות</div>
                                        <div
                                            class="stat-value">{{ round($_c['metrics']['conversions_from_interactions_rate'] * 100, 1)  }}
                                            %
                                        </div>
                                    </div>
                                    <div class="">
                                        <div
                                            class="radial-progress bg-gray-400 text-primary-content border-4 border-primary"
                                            style="--value:{{ round($_c['metrics']['conversions_from_interactions_rate'] * 100)  }};">
                                            {{ round($_c['metrics']['conversions_from_interactions_rate'] * 100)  }}%
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="divider"></div>

                            <div class="stats shadow">

                                <div class="stat text-right flex justify-between">
                                    <div class="stat-figure text-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             class="inline-block w-8 h-8 stroke-current">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="stat-title">מחיר מממוצע לקליק</div>
                                        <div
                                            class="stat-value">{{ round(($_c['metrics']['average_cpc'] / 1000000), 2) }}</div>
                                    </div>
                                </div>

                                <div class="stat text-right flex justify-between">
                                    <div class="stat-figure text-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             class="inline-block w-8 h-8 stroke-current">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="stat-title">מחיר ממוצע להמרה</div>
                                        <div
                                            class="stat-value">{{ round(($_c['metrics']['cost_per_conversion'] / 1000000), 2) }}</div>
                                    </div>
                                </div>

                                <div class="stat text-right flex justify-between">
                                    <div class="stat-figure text-secondary">
                                        <x-antdesign-fund-o class="inline-block w-8 h-8"/>


                                    </div>
                                    <div>
                                        <div class="stat-title">הכנסה</div>
                                        <div class="stat-value">{{ $_c['metrics']['conversions_value'] }}</div>
                                    </div>
                                </div>

                                <div class="stat text-right flex justify-between">
                                    <div class="stat-figure text-secondary">
                                        <x-ri-money-dollar-circle-fill class="inline-block w-8 h-8"/>
                                    </div>
                                    <div>
                                        <div class="stat-title">מחיר כולל</div>
                                        <div
                                            class="stat-value">{{ round(($_c['metrics']['cost_micros'] / 1000000), 2) }}</div>
                                    </div>
                                </div>
                                <div class="stat text-right flex justify-between">
                                    <div class="stat-figure text-secondary">
                                        <x-antdesign-eye-o class="inline-block w-8 h-8"/>
                                    </div>
                                    <div>
                                        <div class="stat-title">חשיפות</div>
                                        <div class="stat-value">{{ $_c['metrics']['impressions'] }}</div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
        <div class="bg-white w-80  shadow-xl mx-2 sm:rounded-lg">
            <div class="container p-2 mx-auto sm:p-4 text-gray-800">
                <x-jet-range-controller content="{{ route('stats.keywords') }}" range="{{ $selected_range }}" />
                <h3 class="text-center mb-2">מילות מפתח</h3>
                <div class="divider"></div>
                <div class="btn-group btn-group-vertical">
                    @foreach($account_performance['ad_rows'] as $_row)
                        <button id="cmp-nav-{{ $_row['ad_group']['id'] }}"
                                data-id="{{ $_row['ad_group']['id'] }}"
                                class="cmp-nav btn btn-outline btn-info border-b @if ($loop->first) btn-active @endif ">
                            <span class="text-right text-black block w-max">
                                {{ $_row['ad_group']['name'] }}
                            </span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
