<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from "@/Components/Paginator.vue";
import { reactive, onMounted } from "vue";
import { Link, router } from "@inertiajs/vue3";


defineProps({
    pages: Array,
    metrics: Array,
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

    if (storedFromDate && storedToDate) {
        dateSelector.fromDate = storedFromDate;
        dateSelector.toDate = storedToDate;
    } else {
        const fromDate = new Date();
        fromDate.setDate(today.getDate() - 28); // Set to 28 days ago
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

    router.get('/page/view/{url_code}', {
        preserveQuery: true,
        from: dateSelector.fromDate,
        to: dateSelector.toDate
    });

    //console.log('Submitting:', dateSelector.fromDate, dateSelector.toDate);

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

        <content>
        <div v-if="$page.props.flash.message" class="alert">
            {{ $page.props.flash.message }}
        </div>
        <slot />
        </content>


        <div class="mt-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-5">
                    <div class="mt-5 mb-4">

                    </div>
                </div>


            </div>

        </div>

    </AppLayout>
</template>

<script>


</script>
