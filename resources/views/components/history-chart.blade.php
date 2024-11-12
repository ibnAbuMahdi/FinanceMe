@props(['data'])
<x-panel class="mb-5">

    <div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
        <div class="flex justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center me-3">
                    <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 19">
                        <path
                            d="M14.5 0A3.987 3.987 0 0 0 11 2.1a4.977 4.977 0 0 1 3.9 5.858A3.989 3.989 0 0 0 14.5 0ZM9 13h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z" />
                        <path
                            d="M5 19h10v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2ZM5 7a5.008 5.008 0 0 1 4-4.9 3.988 3.988 0 1 0-3.9 5.859A4.974 4.974 0 0 1 5 7Zm5 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm5-1h-.424a5.016 5.016 0 0 1-1.942 2.232A6.007 6.007 0 0 1 17 17h2a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5ZM5.424 9H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h2a6.007 6.007 0 0 1 4.366-5.768A5.016 5.016 0 0 1 5.424 9Z" />
                    </svg>
                </div>
                <div>
                    <h5 id=totalSpent class="leading-none text-2xl font-bold text-gray-900 dark:text-white pb-1"></h5>
                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Total spending</p>
                </div>
            </div>
            
        </div>

        <div class="grid grid-cols-2">
            <dl class="flex items-center">
                <dt class="text-gray-500 dark:text-gray-400 text-sm font-normal me-1">Average spending:</dt>
                <dd id="averageSpending" class="text-gray-900 text-sm dark:text-white font-semibold"></dd>
            </dl>
            
        </div>

        <div id="column-chart"></div>
        
    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let data = @json($data);
                let budget_amount = []
                let actual_amount = []
                data.forEach(e => {
                    budget_amount.push({x: e.title, y: e.amount})
                    actual_amount.push({x: e.title, y: e.total_amount})
                });
                let arr = []
                actual_amount.map((e) => {arr.push(e.y)})
                let total_spend =  arr.reduce((a,b) => a + b)
                let average_spend = total_spend/actual_amount.length
                let total_element =document.getElementById('totalSpent')
                total_element.innerHTML = total_spend
                let average_element =document.getElementById('averageSpending')
                average_element.innerHTML = average_spend

                const options = {
                    colors: ["#1A56DB", "#FDBA8C"],
                    series: [
                        {
                            name: "Budget Amount",
                            color: "#1A56DB",
                            data: budget_amount,
                        },
                        {
                            name: "Actual Amount",
                            color: "#FDBA8C",
                            data: actual_amount,
                        },
                    ],
                    chart: {
                        type: "bar",
                        height: "320px",
                        fontFamily: "Inter, sans-serif",
                        toolbar: {
                            show: false,
                        },
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: "70%",
                            borderRadiusApplication: "end",
                            borderRadius: 8,
                        },
                    },
                    tooltip: {
                        shared: true,
                        intersect: false,
                        style: {
                            fontFamily: "Inter, sans-serif",
                        },
                    },
                    states: {
                        hover: {
                            filter: {
                                type: "darken",
                                value: 1,
                            },
                        },
                    },
                    stroke: {
                        show: true,
                        width: 0,
                        colors: ["transparent"],
                    },
                    grid: {
                        show: false,
                        strokeDashArray: 4,
                        padding: {
                            left: 2,
                            right: 2,
                            top: -14
                        },
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    legend: {
                        show: false,
                    },
                    xaxis: {
                        floating: false,
                        labels: {
                            show: true,
                            style: {
                                fontFamily: "Inter, sans-serif",
                                cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                            }
                        },
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false,
                        },
                    },
                    yaxis: {
                        show: false,
                    },
                    fill: {
                        opacity: 1,
                    },
                }

                if (document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
                    const chart = new ApexCharts(document.getElementById("column-chart"), options);
                    chart.render();
                }

            });
        </script>
    @endpush
</x-panel>
