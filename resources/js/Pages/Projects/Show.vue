<script setup>
import { Head } from '@inertiajs/vue3';

defineProps({
    projects: Array ,
});
</script>

<template>
    <Head title="Projects" />

    <div class="font-sans text-gray-900 antialiased">

       <ul>
        <li
        v-for="project in projects"
        :key="project.id"
        v-text="project.name"
        ></li>
       </ul>
    </div>
</template>
