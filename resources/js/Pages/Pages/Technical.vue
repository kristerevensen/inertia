<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from "@/Components/Paginator.vue";
import { reactive, onMounted, ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import NavLink from '@/Components/NavLink.vue';
const props = defineProps({
  //  pages: Object,
});
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
const tabs = [
  { name: 'All Pages', href: '/pages', current: false },
  { name: 'Technical', href: '/pages/technical', current: true },
  { name: 'Content', href: '/pages/content', current: false },
  { name: 'Ranking', href: '/pages/ranking', current: false },
]
</script>


<template>
    <AppLayout title="Technical">

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
                            Technical
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
            </div>
        </div>
    </AppLayout>
</template>
