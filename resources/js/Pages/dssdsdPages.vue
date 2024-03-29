

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from "@/Components/Paginator.vue";
import { reactive, onMounted, ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import NavLink from '@/Components/NavLink.vue';



const props = defineProps({
    pages: Object,
    metrics: Object, // changed to Object as it seems to be a singular object
    pageviews: Object,
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
    const storedDateSet = localStorage.getItem('dateSet');

    const today = new Date();
    const formattedToday = formatDate(today);

    // Check if the stored date is today's date
    if (storedDateSet === formattedToday && storedFromDate && storedToDate) {
        dateSelector.fromDate = storedFromDate;
        dateSelector.toDate = storedToDate;
    } else {
        // Set default dates to the last 28 days excluding today
        const toDate = new Date(today);
        toDate.setDate(toDate.getDate() - 1); // Set to yesterday

        const fromDate = new Date(toDate);
        fromDate.setDate(fromDate.getDate() - 27); // Set to 28 days before yesterday

        dateSelector.fromDate = formatDate(fromDate);
        dateSelector.toDate = formatDate(toDate);

        // Store the current date as the date set
        localStorage.setItem('dateSet', formattedToday);
        localStorage.setItem('fromDate', dateSelector.fromDate);
        localStorage.setItem('toDate', dateSelector.toDate);
    }
});


if (!dateSelector.fromDate || !dateSelector.toDate) {
    // Get today's date
    let today = new Date();

    // Set toDate as yesterday
    let toDate = new Date(today);
    toDate.setDate(toDate.getDate() - 1);

    // Set fromDate as 28 days before yesterday
    let fromDate = new Date(toDate);
    fromDate.setDate(fromDate.getDate() - 27);

    // Format dates to 'YYYY-MM-DD'
    let formattedToDate = toDate.toISOString().split('T')[0];
    let formattedFromDate = fromDate.toISOString().split('T')[0];

    // Assign the default values
    dateSelector.fromDate = formattedFromDate;
    dateSelector.toDate = formattedToDate;
}

// Method to submit date range and store in localStorage
function submitDateRange() {
    if (!dateSelector.fromDate || !dateSelector.toDate) {
        alert('Please select both from and to dates');
        return;
    }

    localStorage.setItem('fromDate', dateSelector.fromDate);
    localStorage.setItem('toDate', dateSelector.toDate);

    router.get('/pages', {
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
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
    }
});

function drawChart() {
    var data = google.visualization.arrayToDataTable(chartData.value);

    var options = {
        title: 'Pageviews Trend',
        curveType: 'function',
        legend: { position: 'bottom' }
    };

    var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
    chart.draw(data, options);
}
const tabs = [
  { name: 'All Pages', href: '/pages', current: false },
  { name: 'Technical', href: '#', current: false },
  { name: 'Content', href: '#', current: true },
  { name: 'Ranking', href: '#', current: false },
]
</script>


<template>
    <AppLayout title="Pages">





        <div class="mt-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="relative border-b border-gray-200 pb-5 sm:pb-0">
                    <div class="md:flex md:items-center md:justify-between">
                      <h3 class="text-base font-semibold leading-6 text-gray-900">Pages</h3>
                      <div class="flex space-x-2 mt-3 md:absolute md:right-0 md:top-5 md:mt-0">
                        <input type="date" v-model="dateSelector.fromDate" class="border-gray-300 rounded-md">
                        <input type="date" v-model="dateSelector.toDate" class="border-gray-300 rounded-md">
                        <button @click="submitDateRange" class="px-4 py-2 bg-blue-500 text-white rounded-md">
                            Data Period</button>
                </div>
                    </div>
                    <div class="mt-4">
                      <div class="sm:hidden">
                        <label for="current-tab" class="sr-only">Select a tab</label>
                        <select id="current-tab" name="current-tab" class="block w-full rounded-md border-0 py-1.5 pl-3 pr-10 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600">
                          <option v-for="tab in tabs" :key="tab.name" :selected="tab.current" >{{ tab.name }}</option>
                        </select>
                        <NavLink :href="route('pages')" :active="route().current('pages')">
                            Pages
                        </NavLink>
                      </div>
                      <div class="hidden sm:block">
                        <nav class="-mb-px flex space-x-8">
                          <a v-for="tab in tabs" :key="tab.name" :href="tab.href" :class="[tab.current ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700', 'whitespace-nowrap border-b-2 px-1 pb-4 text-sm font-medium']" :aria-current="tab.current ? 'page' : undefined">{{ tab.name }}</a>
                        </nav>
                      </div>
                    </div>
                  </div>
                <div class="mb-5">
                    <div class="mt-5 mb-4">

                    </div>
                </div>
                <div class="">
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

                </div>

                <div class="mt-10 rounded-lg bg-white  shadow sm:p-6">
                    <div id="curve_chart" style="width:100%; height: 500px"></div>
                </div>



                <div class="overflow-hidden mt-10 shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>

                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    Page Path
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Pageviews
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Bounce%
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Entrance%
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Exit%
                                </th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <tr v-for="page in pages.data" :key="page.id">

                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                    <Link :href="`/page/view/${page.url_code}`" class="hover:underline">{{
                                        truncateUrl(page.url) }}</Link>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ page.pageviews }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ (page.bounce / page.pageviews * 100).toFixed(2) }}%
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ (page.entrance / page.pageviews * 100).toFixed(2) }}%
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ (page.exits / page.pageviews * 100).toFixed(2) }}%
                                </td>
                                <td
                                    class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <Link :href="'/project/${project.id}/edit'"
                                        class="text-indigo-600 hover:text-indigo-900">
                                    Edit
                                    </Link>
                                </td>
                            </tr>

                            <!-- More people... -->
                        </tbody>
                    </table>
                </div>
                <Pagination :links="pages.links" class="mt-6 pb-10" />
            </div>

        </div>

    </AppLayout>
</template>

