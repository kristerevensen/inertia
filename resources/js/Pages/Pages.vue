<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

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
            </div>
        </div>
    </AppLayout>
</template>

<script>


</script>
