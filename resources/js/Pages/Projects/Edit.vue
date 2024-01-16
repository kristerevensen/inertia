<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { PhotoIcon, UserCircleIcon } from '@heroicons/vue/24/solid'
import { computed, defineProps } from 'vue'

const props = defineProps({
    project: Object,
    projectCode: String,
});

let project = props.project;

const trackingScript = computed(() => {
    return `<!-- MeasureTank Tracking Snippet -->
<script>
  (function() {
    var mt = document.createElement('script'); mt.type = 'text/javascript'; mt.async = true;
    mt.src = 'https://tracking.measuretank.com/tracking.js';
    mt.setAttribute('data-project-code', '${props.project.project_code}');
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(mt, s);
  })();
</` + `script>`;
});

const copyTrackingCode = () => {
    navigator.clipboard.writeText(trackingScript.value);
    alert('Tracking code copied to clipboard');
}
</script>


<template>
    <AppLayout title="Edit Project">
        <template #header>
            <div class="flex justify-between">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ $page.props.project.name }}
                    </h2>
                </div>

            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px lg:px-0">
                <div class="sm:px-6 lg:px-8">
                    <div class="space-y-10 divide-y divide-gray-900/10">
                        <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-3">
                            <div class="px-4 sm:px-0">
                                <h2 class="text-base font-semibold leading-7 text-gray-900">Tracking Information</h2>
                                <p class="mt-1 text-sm leading-6 text-gray-600">Make sure the domain given, is the correct
                                    one you collect data for.</p>
                            </div>

                            <form class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                                <div class="px-4 py-6 sm:p-8">
                                    <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                        <div class="sm:col-span-4">
                                            <label for="website"
                                                class="block text-sm font-medium leading-6 text-gray-900">Domain</label>
                                            <div class="mt-2">
                                                <div
                                                    class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                                    <span
                                                        class="flex select-none items-center pl-3 text-gray-500 sm:text-sm">http://</span>
                                                    <input type="text" v-model="project.domain" name="domain" id="domain"
                                                        disabled
                                                        class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                                        placeholder="www.example.com" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-span-full">
                                            <label for="about"
                                                class="block text-sm font-medium leading-6 text-gray-900">Tracking
                                                Code</label>
                                            <div class="mt-2">
                                                <textarea id="about" v-model="trackingScript" name="about" rows="10"
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </textarea>
                                            </div>
                                            <p class="mt-3 text-sm leading-6 text-gray-600">Must be put in head of HTML
                                                document.</p>
                                        </div>


                                    </div>
                                </div>
                                <div
                                    class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                                    <button type="submit" @click="copyTrackingCode"
                                        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        Copy Tracking Snippet</button>
                                </div>
                            </form>
                        </div>

                        <div class="grid grid-cols-1 gap-x-8 gap-y-8 pt-10 md:grid-cols-3">
                            <div class="px-4 sm:px-0">
                                <h2 class="text-base font-semibold leading-7 text-gray-900">Project Information</h2>
                                <p class="mt-1 text-sm leading-6 text-gray-600">Makes changes to your project settings</p>
                            </div>

                            <form class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                                <div class="px-4 py-6 sm:p-8">
                                    <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                        <div class="sm:col-span-3">
                                            <label for="first-name"
                                                class="block text-sm font-medium leading-6 text-gray-900">Project Name</label>
                                            <div class="mt-2">
                                                <input
                                                    type="text"
                                                    v-model="project.name"
                                                    name="name"
                                                    id="project_name"

                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                            </div>
                                        </div>

                                        <div class="sm:col-span-3">
                                            <label for="last-name"
                                                class="block text-sm font-medium leading-6 text-gray-900">Project Domain</label>
                                            <div class="mt-2">
                                                <input
                                                    type="text"
                                                    name="domain"
                                                    v-model="project.domain"
                                                    id="project_domain"
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                            </div>
                                        </div>

                                        <div class="sm:col-span-4">
                                            <label for="email"
                                                class="block text-sm font-medium leading-6 text-gray-900">Email
                                                address</label>
                                            <div class="mt-2">
                                                <input id="email" name="email" type="email" autocomplete="email"
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                            </div>
                                        </div>

                                        <div class="sm:col-span-3">
                                            <label for="country"
                                                class="block text-sm font-medium leading-6 text-gray-900">Country</label>
                                            <div class="mt-2">
                                                <select id="country" name="country" autocomplete="country-name"
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                                    <option>Norway</option>
                                                    <option>Canada</option>
                                                    <option>Mexico</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="sm:col-span-3">
                                            <label for="country"
                                                class="block text-sm font-medium leading-6 text-gray-900">Language</label>
                                            <div class="mt-2">
                                                <select id="country" name="country" autocomplete="country-name"
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                                    <option>no-nb</option>
                                                    <option>Language2</option>
                                                    <option>Language3</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-span-full">
                                            <label for="street-address"
                                                class="block text-sm font-medium leading-6 text-gray-900">Street
                                                address</label>
                                            <div class="mt-2">
                                                <input type="text" name="street-address" id="street-address"
                                                    autocomplete="street-address"
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                            </div>
                                        </div>

                                        <div class="sm:col-span-2 sm:col-start-1">
                                            <label for="city"
                                                class="block text-sm font-medium leading-6 text-gray-900">City</label>
                                            <div class="mt-2">
                                                <input type="text" name="city" id="city" autocomplete="address-level2"
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                            </div>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label for="region"
                                                class="block text-sm font-medium leading-6 text-gray-900">State /
                                                Province</label>
                                            <div class="mt-2">
                                                <input type="text" name="region" id="region" autocomplete="address-level1"
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                            </div>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label for="postal-code"
                                                class="block text-sm font-medium leading-6 text-gray-900">ZIP / Postal
                                                code</label>
                                            <div class="mt-2">
                                                <input type="text" name="postal-code" id="postal-code"
                                                    autocomplete="postal-code"
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                                    <button type="button"
                                        class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
                                    <button type="submit"
                                        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                                </div>
                            </form>
                        </div>


                    <div class="grid grid-cols-1 gap-x-8 gap-y-8 pt-10 md:grid-cols-3">
                            <div class="px-4 sm:px-0">
                                <h2 class="text-base font-semibold leading-7 text-gray-900">Delete Project</h2>
                                <p class="mt-1 text-sm leading-6 text-gray-600">This action cannot be undone.</p>
                            </div>

                            <form class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">

                                <div
                                    class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">

                                    <button
                                        type="submit"
                                        @click="event.preventDefault(); if (confirm('Are you sure you want to delete this project?')) { document.getElementById('delete-project-form').submit(); }"
                                        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        Delete Project</button>
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</AppLayout></template>

