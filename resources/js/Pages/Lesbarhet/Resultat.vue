<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';


import { defineProps } from 'vue';

const props = defineProps({
  liks: Number
});
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Readability Results
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <h1>Readability Index: {{ liks }}</h1>
                        <inertia-link href="/lesbarhet">Go back</inertia-link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
