<x-layout>
    <x-page-heading>
        Dashboard
    </x-page-heading>
    <div class="flex flex-row gap-x-6">
        <x-add-transaction :$data></x-add-transaction>
        <div class="basis-1/2">
            <x-forms.label label="Total Transactions" name="total_transactions"></x-forms.label>

            <x-panel class="space-y-6 gap-x-6">
                @foreach ($data['budgets'] as $budget)
                    <div>
                        <label class="font-bold"></label>
                        <div class="flex justify-between mb-1">
                            <span class="text-base font-medium text-blue-700 dark:text-white">{{ $budget['title'] }}</span>
                            <span class="text-sm font-medium text-blue-700 dark:text-white">
                                {{round(($budget['total_amount'] / $budget['amount']) * 100, 2)}}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                            <div class="bg-blue-600 text-xs font-medium text-blue-100 h-4 text-center p-0.5 leading-none rounded-full"
                                style="width: {{round(($budget['total_amount'] / $budget['amount']) * 100, 2)}}%"></div>
                        </div>
                    </div>
                @endforeach
            </x-panel>

            <x-forms.label label="Transactions" name="transactions"></x-forms.label>
            <x-graph-card>

                <div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                    <div class="flex justify-between">
                        <div>
                            <h5 class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2">
                                @if (count($data['budget_transactions']))
                                    {{ $data['averages']['recent_average']['amount__avg'] }}
                                @endif
                            </h5>
                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">average spending</p>
                        </div>
                        @if (count($data['budget_transactions']))
                                                @php
                                                    $change = $data['averages']['diff']
                                                @endphp
                                                @if ($change < 0)
                                                    <div
                                                        class="flex items-center px-2.5 py-0.5 text-base font-semibold text-red-500 dark:text-red-500 text-center">
                                                        {{ abs($change) * 100 }}%
                                                        <svg class="h-5 w-5 text-red-500" width="24" height="24" viewBox="0 0 24 24"
                                                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" />
                                                            <line x1="12" y1="5" x2="12" y2="19" />
                                                            <line x1="16" y1="15" x2="12" y2="19" />
                                                            <line x1="8" y1="15" x2="12" y2="19" />
                                                        </svg>
                                                    </div>
                                                @else
                                                    <div
                                                        class="flex items-center px-2.5 py-0.5 text-base font-semibold text-green-500 dark:text-green-500 text-center">
                                                        {{ abs($change) * 100 }}%
                                                        <svg class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 10 14">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4" />
                                                        </svg>
                                                    </div>
                                                @endif
                        @endif
                    </div>
                    <div id="area-chart"></div>
                    <div
                        class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
                        <div class="flex justify-between items-center pt-5">
                            <!-- Button -->
                            <button id="dropdownDefaultButton" data-dropdown-toggle="budgetsDropdown"
                                data-dropdown-placement="bottom"
                                class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                                type="button">
                                {{ $budget_title ?? "No budgets found" }}
                                <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <!-- Dropdown menu -->
                            <div id="budgetsDropdown"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownDefaultButton">
                                    @foreach ($data['budgets'] as $budget)
                                        <li>
                                            <a href="/budgets/{{$budget['id']}}/transactions"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ $budget['title']}}</a>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>

                        </div>
                    </div>
                </div>

            </x-graph-card>
            <x-forms.label label="Transactions Distribution" name="transactions_distribution"></x-forms.label>
            <x-graph-card>

                <div class=" w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">

                    <div class="flex justify-between items-start w-full">
                        <div class="flex-col items-center">
                            <div class="flex items-center mb-1">
                                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white me-1">Spend distribution</h5>                                
                            </div>
                            
                            
                        </div>
                        
                    </div>

                    <!-- Line Chart -->
                    <div class="py-6" id="pie-chart"></div>

                    
                </div>

            </x-graph-card>
        </div>
        <x-add-budget></x-add-budget>
    </div>



    @push('scripts')
        <script>
            let data = @json($data);
            let budget_title = '{{ $budget_title }}'
            budget_title = !budget_title || 'false' ? '' : budget_title
            let amounts = []
            let dates = []
            data.budget_transactions.forEach(e => {
                amounts.push(e.amount)
                dates.push(e.date)
            });
            document.addEventListener("DOMContentLoaded", function () {
                const options = {
                    chart: {
                        height: "100%",
                        maxWidth: "100%",
                        type: "area",
                        fontFamily: "Inter, sans-serif",
                        dropShadow: {
                            enabled: false,
                        },
                        toolbar: {
                            show: false,
                        },
                    },
                    tooltip: {
                        enabled: true,
                        x: {
                            show: false,
                        },
                    },
                    fill: {
                        type: "gradient",
                        gradient: {
                            opacityFrom: 0.55,
                            opacityTo: 0,
                            shade: "#1C64F2",
                            gradientToColors: ["#1C64F2"],
                        },
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    stroke: {
                        width: 6,
                    },
                    grid: {
                        show: false,
                        strokeDashArray: 4,
                        padding: {
                            left: 2,
                            right: 2,
                            top: 0
                        },
                    },
                    series: [
                        {
                            name: budget_title,
                            data: amounts,
                            color: "#1A56DB",
                        },
                    ],
                    xaxis: {
                        categories: dates,
                        labels: {
                            show: true,
                        },
                        axisBorder: {
                            show: true,
                        },
                        axisTicks: {
                            show: false,
                        },
                    },
                    yaxis: {
                        show: true,
                    },
                }

                if (document.getElementById("area-chart") && typeof ApexCharts !== 'undefined') {
                    const chart = new ApexCharts(document.getElementById("area-chart"), options);
                    chart.render();
                }

                let series = []
                let labels = []
                const colors = [];

                for (let i = 0; i < data.budgets.length; i++) {
                    const randomColor = "#" + Math.floor(Math.random() * 16777215).toString(16);
                    colors.push(randomColor);
                }

                data.budgets.forEach(e => {
                    series.push(e.total_amount)
                    labels.push(e.title)
                });
                const getChartOptions = () => {
                    return {
                        series: series,
                        // series: [52.8, 26.8, 10.4],
                        colors: colors,
                        chart: {
                            height: 350,
                            width: "100%",
                            type: "pie",
                        },
                        stroke: {
                            colors: ["white"],
                            lineCap: "",
                        },
                        plotOptions: {
                            pie: {
                                labels: {
                                    show: true,
                                },
                                size: "100%",
                                dataLabels: {
                                    offset: -25
                                }
                            },
                        },
                        labels: labels,
                        dataLabels: {
                            enabled: true,
                            style: {
                                fontFamily: "Inter, sans-serif",
                            },
                        },
                        legend: {
                            position: "bottom",
                            fontFamily: "Inter, sans-serif",
                        },
                        yaxis: {
                            labels: {
                                formatter: function (value) {
                                    return value
                                },
                            },
                        },
                        xaxis: {
                            labels: {
                                formatter: function (value) {
                                    return value
                                },
                            },
                            axisTicks: {
                                show: false,
                            },
                            axisBorder: {
                                show: false,
                            },
                        },
                    }
                }

                if (document.getElementById("pie-chart") && typeof ApexCharts !== 'undefined') {
                    const chart = new ApexCharts(document.getElementById("pie-chart"), getChartOptions());
                    chart.render();
                }
            });
        </script>

    @endpush
</x-layout>