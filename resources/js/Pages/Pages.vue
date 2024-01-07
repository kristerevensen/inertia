<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from "@/Components/Paginator.vue";
import { ref, reactive } from "vue";
import { Link, router } from "@inertiajs/vue3";

defineProps({
    pages: Array,
});

const form = reactive({
    form_search: null,
});

function submit() {
    router.post("/Dashboard", form);
}
</script>

<template>
    <AppLayout title="Pages">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pages
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-5">
                    <div class="relative flex flex-col rounded-lg bg-white bg-clip-border text-gray-700 shadow">
                        <div class="relative h-350-px">

                        </div>
                    </div>
                </div>
                <div class="">
                    <div>
                        <h3 class="text-base font-semibold leading-6 text-gray-900">Last 30 days</h3>
                        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
                            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                                <dt class="truncate text-sm font-medium text-gray-500">Total Subscribers</dt>
                                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">71,897</dd>
                            </div>
                            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                                <dt class="truncate text-sm font-medium text-gray-500">Avg. Open Rate</dt>
                                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">58.16%</dd>
                            </div>
                            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                                <dt class="truncate text-sm font-medium text-gray-500">Avg. Click Rate</dt>
                                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">24.57%</dd>
                            </div>
                        </dl>
                    </div>

                </div>

                <div class="overflow-hidden mt-10 shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="relative px-7 sm:w-12 sm:px-6">
                                    <input type="checkbox"
                                        class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                                </th>
                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    Page Path
                                </th>
                                <th scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Pageviews
                                </th>
                                <th scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Bouncerate
                                </th>
                                <th scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Entrances
                                </th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <tr v-for="page in pages.data" :key="page.id">
                                <td class="relative px-7 sm:w-12 sm:px-6">
                                    <!-- Selected row marker, only show when row is selected. -->
                                    <!-- <div class="absolute inset-y-0 left-0 w-0.5 bg-indigo-600"></div> -->

                                    <input type="checkbox" value="{{ project.id }}"
                                        class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                                </td>
                                <td
                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                    {{ page.url }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ page.pageviews }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ page.bounce }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ page.entrance }}
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
                <Pagination :links="pages.links" class="mt-6" />
            </div>

        </div>

    </AppLayout>
</template>

<script>


</script>
