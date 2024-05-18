<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';


</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Lesbarhet
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <form method="POST" action="{{ url('/lesbarhet') }}">
                        @csrf
                        <textarea name="tekst" rows="10" cols="30"></textarea>
                        <button type="submit">Beregn LIKS</button>
                    </form>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
