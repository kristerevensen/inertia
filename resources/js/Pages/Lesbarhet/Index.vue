<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from "vue";


const tekst = ref('');

async function sendTekst() {
  const text = tekst.value;
  console.log(text);
  const metaToken = document.querySelector('meta[name="csrf-token"]');
  const token = metaToken ? metaToken.getAttribute('content') : '';

  const response = await fetch('/lesbarhet', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': token, // Include the CSRF token in the headers
    },
    body: JSON.stringify({ tekst: text }),
  });3
  // Handle the response here (e.g., check for errors, extract data)
}
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Readability Calculator
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                 <div class="">
                    <div class="p-4 max-w-4xl mx-auto">
                        <form @submit.prevent="sendTekst" class="flex flex-col space-y-4">
                        <textarea v-model="tekst" rows="10" class="p-2 w-full h-64 border-2 border-gray-300 rounded-lg resize-none focus:border-blue-500 focus:outline-none" placeholder="Lim inn tekst her eller oppgi en URL..."></textarea>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">Analyser Lesbarhet</button>
                        </form>
                    </div>
                    </div>
            </div>
        </div>
    </AppLayout>
</template>
