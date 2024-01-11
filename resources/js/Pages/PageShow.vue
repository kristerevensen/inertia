<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from "@/Components/Paginator.vue";
import { reactive, onMounted, ref } from "vue";
import { Link, router } from "@inertiajs/vue3";



const props = defineProps({
    page: Object,
    metrics: Object, // changed to Object as it seems to be a singular object
    pageviews: Object,
    params: Array,
});



// Add the truncateUrl method here
function truncateUrl(url) {
    const maxLength = 50;
    return url.length > maxLength ? `${url.substring(0, maxLength)}...` : url;
}

const dateSelector = reactive({
    form_search: null,
    fromDate: null,
    toDate: null,
});

// Function to format date to YYYY-MM-DD
function formatDate(date) {
    return new Date(date).toISOString().split('T')[0];
}

// Set or retrieve dates when the component is mounted
onMounted(() => {
    const storedFromDate = localStorage.getItem('fromDate');
    const storedToDate = localStorage.getItem('toDate');
    const today = new Date();
    today.setDate(today.getDate() - 1); // Set to yesterday

    if (storedFromDate && storedToDate) {
        dateSelector.fromDate = storedFromDate;
        dateSelector.toDate = storedToDate;
    } else {
        const fromDate = new Date();
        fromDate.setDate(today.getDate() - 29); // Set to 28 days ago
        dateSelector.fromDate = formatDate(fromDate);
        dateSelector.toDate = formatDate(today);
    }
});

// Method to submit date range and store in localStorage
function submitDateRange() {
    if (!dateSelector.fromDate || !dateSelector.toDate) {
        alert('Please select both from and to dates');
        return;
    }

    localStorage.setItem('fromDate', dateSelector.fromDate);
    localStorage.setItem('toDate', dateSelector.toDate);

    let pagePath = window.location.pathname;

    router.get(pagePath, {
        preserveQuery: true,
        from: dateSelector.fromDate,
        to: dateSelector.toDate
    });

    //console.log('Submitting:', dateSelector.fromDate, dateSelector.toDate);

}

function formatDateChart(dateString) {
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const date = new Date(dateString);
    const formattedDate = `${months[date.getMonth()]} ${date.getDate().toString().padStart(2, '0')}`;
    return formattedDate;
}

const chartData = ref([]);

// Convert pageviews data to Google Charts format
onMounted(() => {
    if (props.pageviews && props.pageviews.original) {
        chartData.value.push(['Date', 'Pageviews']);
        props.pageviews.original.forEach(item => {
            chartData.value.push([formatDateChart(item.date), item.pageviews]);
        });
        google.charts.load('current', { 'packages': ['corechart'] });
        google.charts.setOnLoadCallback(drawChart);
    }
});



function drawChart() {
    var data = google.visualization.arrayToDataTable(chartData.value);

    var options = {
        curveType: 'function',
        legend: { position: 'bottom' },
    };

    var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
    chart.draw(data, options);
}

</script>

<template>
    <AppLayout title="Pages">
        <template #header>
            <div class="flex justify-between">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Pages
                    </h2>
                </div>
                <div>
                    <div class="flex space-x-2">
                        <input type="date" v-model="dateSelector.fromDate" class="border-gray-300 rounded-md">
                        <input type="date" v-model="dateSelector.toDate" class="border-gray-300 rounded-md">
                        <button @click="submitDateRange" class="px-4 py-2 bg-blue-500 text-white rounded-md">
                            Data Period</button>

                    </div>
                </div>
            </div>


        </template>


        <div class="mt-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-5">
                    <div class="mt-5 mb-4 flex justify-between py-2 px-2">
                        <div class="">
                            <h2>{{ page.title }} </h2>
                        </div>
                        <div>
                            <span class="font-semibold">{{ truncateUrl(page.url) }}</span>
                        </div>
                    </div>
                    <div>

                    </div>
                </div>
                <div class=""> <!-- start list of metrics --->
                    <div>
                        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-5">
                            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                                <dt class="truncate text-sm font-medium text-gray-500">Sessions</dt>
                                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ metrics.sessions }}
                                </dd>
                            </div>
                            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                                <dt class="truncate text-sm font-medium text-gray-500">Pageviews</dt>
                                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ metrics.pageviews }}
                                </dd>
                            </div>
                            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                                <dt class="truncate text-sm font-medium text-gray-500">Entrances</dt>
                                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ metrics.entrances }}
                                </dd>
                            </div>
                            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                                <dt class="truncate text-sm font-medium text-gray-500">Exits</dt>
                                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ metrics.exits }}
                                </dd>
                            </div>
                            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                                <dt class="truncate text-sm font-medium text-gray-500">Bounce</dt>
                                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ metrics.bounce }}
                                </dd>
                            </div>
                        </dl>
                    </div>

                </div><!-- end list of metrics --->
                <div>
                    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-5">
                        <div class="sm:col-span-3 rounded-lg bg-white shadow sm:p-6">
                            <div id="curve_chart" style=" height: 300px"></div>
                        </div>
                        <div class="sm:col-span-2">
                            <h2 class="px-2 py-2">Technical data</h2>
                            <ul role="list"
                                class="divide-y divide-gray-100 overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                                <li class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6">
                                    <div class="flex min-w-0 gap-x-4">

                                        <div class="min-w-0 flex-auto">
                                            <p class="text-sm font-semibold leading-6 text-gray-900">
                                                <a href="#">
                                                    <span class="absolute inset-x-0 -top-px bottom-0"></span>
                                                    Form count
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex shrink-0 items-center gap-x-4">
                                        <div class="hidden sm:flex sm:flex-col sm:items-end">
                                            <p class="text-sm leading-6 text-gray-900">{{ page.form_count }}</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6">
                                    <div class="flex min-w-0 gap-x-4">

                                        <div class="min-w-0 flex-auto">
                                            <p class="text-sm font-semibold leading-6 text-gray-900">
                                                <a href="#">
                                                    <span class="absolute inset-x-0 -top-px bottom-0"></span>
                                                    Inbound Links
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex shrink-0 items-center gap-x-4">
                                        <div class="hidden sm:flex sm:flex-col sm:items-end">
                                            <p class="text-sm leading-6 text-gray-900">{{ page.inbound_links }}</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6">
                                    <div class="flex min-w-0 gap-x-4">

                                        <div class="min-w-0 flex-auto">
                                            <p class="text-sm font-semibold leading-6 text-gray-900">
                                                <a href="#">
                                                    <span class="absolute inset-x-0 -top-px bottom-0"></span>
                                                    Outbound Links
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex shrink-0 items-center gap-x-4">
                                        <div class="hidden sm:flex sm:flex-col sm:items-end">
                                            <p class="text-sm leading-6 text-gray-900">{{ page.outbound_links }}</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6">
                                    <div class="flex min-w-0 gap-x-4">

                                        <div class="min-w-0 flex-auto">
                                            <p class="text-sm font-semibold leading-6 text-gray-900">
                                                <a href="#">
                                                    <span class="absolute inset-x-0 -top-px bottom-0"></span>
                                                    Word Count
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex shrink-0 items-center gap-x-4">
                                        <div class="hidden sm:flex sm:flex-col sm:items-end">
                                            <p class="text-sm leading-6 text-gray-900">{{ page.word_count }}</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6">
                                    <div class="flex min-w-0 gap-x-4">

                                        <div class="min-w-0 flex-auto">
                                            <p class="text-sm font-semibold leading-6 text-gray-900">
                                                <a href="#">
                                                    <span class="absolute inset-x-0 -top-px bottom-0"></span>
                                                    Protocol
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex shrink-0 items-center gap-x-4">
                                        <div class="hidden sm:flex sm:flex-col sm:items-end">
                                            <p class="text-sm leading-6 text-gray-900">{{ page.protocol }}</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </dl>
                </div>

                <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">

                    <div> <!-- start list of parameters --->
                        <h2 class="px-2 py-2">Parameters</h2>
                        <ul class="divide-y divide-gray-100 overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                            <li v-for="(parameter, index) in params" :key="index" class="relative flex justify-between gap-x-6 px-4 py-5  sm:px-6">
                            <div class="flex min-w-0 gap-x-4">
                                <div class="min-w-0 flex-auto">
                                <p class="text-sm font-semibold leading-6 text-gray-900">

                                    <span class="absolute inset-x-0 -top-px bottom-0"></span>
                                    {{ parameter }}

                                </p>

                                </div>
                            </div>
                            <div class="flex shrink-0 items-center gap-x-4">
                                <div class="hidden sm:flex sm:flex-col sm:items-end">
                                    <p class="text-sm leading-6 text-gray-900">
                                        <button class="bg-blue-500 text-white px-3 py-1 text-xs leading-5 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                                            Add to filter
                                        </button>
                                    </p>

                                </div>
                            </div>
                            </li>

                        </ul>
                    </div> <!-- end list of parameters --->
                </dl>



            </div>
        </div>
    </AppLayout>
</template>

<script>


</script>
