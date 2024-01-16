<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { PhotoIcon, UserCircleIcon } from '@heroicons/vue/24/solid'
import { computed, defineProps, ref } from 'vue'

const props = defineProps({
    project: Object,
    projectCode: String,
});


const selectedCountry = ref(''); // Default value can be set here
const selectedLanguage = ref(''); // Default value can be set here

let project = props.project;

const copyTrackingCode = () => {
    navigator.clipboard.writeText(trackingScript.value);
    alert('Tracking code copied to clipboard');
}

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

const tabs = [
  { name: 'Settings', href: `/project/${project.project_code}/settings`, current: false },
  { name: 'Filters', href: `/project/${project.project_code}/filters`, current: false },
];
</script>


<template>
    <AppLayout title="Edit Project">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px lg:px-0">
                <div class="sm:px-6 lg:px-8">
                    <div class="relative border-b border-gray-200 pb-5 sm:pb-0 mb-10">
                        <div class="md:flex md:items-center md:justify-between">
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Project Settings
                    </h2>

                        </div>
                        <div class="mt-4">
                        <div class="sm:hidden">
                            <select id="current-tab" name="current-tab" class="block w-full rounded-md border-0 py-1.5 pl-3 pr-10 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600">
                            <option v-for="tab in tabs" :key="tab.name" :selected="tab.current">{{ tab.name }}</option>
                            </select>
                        </div>
                        <div class="hidden sm:block">
                            <nav class="-mb-px flex space-x-8">
                            <a v-for="tab in tabs" :key="tab.name" :href="tab.href" :class="[tab.current ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700', 'whitespace-nowrap border-b-2 px-1 pb-4 text-sm font-medium']" :aria-current="tab.current ? 'page' : undefined">{{ tab.name }}</a>
                            </nav>
                        </div>
                        </div>
                    </div>


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
                                                class="block text-sm font-medium leading-6 text-gray-900">Project
                                                Name</label>
                                            <div class="mt-2">
                                                <input type="text" v-model="project.name" name="name" id="project_name"
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                            </div>
                                        </div>

                                        <div class="sm:col-span-3">
                                            <label for="last-name"
                                                class="block text-sm font-medium leading-6 text-gray-900">Project
                                                Domain</label>
                                            <div class="mt-2">
                                                <input type="text" name="domain" v-model="project.domain"
                                                    id="project_domain"
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                            </div>
                                        </div>

                                        <div class="sm:col-span-6">
                                            <label for="email"
                                                class="block text-sm font-medium leading-6 text-gray-900">Project
                                                Description</label>
                                            <div class="mt-2">
                                                <textarea id="about" v-model="project.description" name="about" rows="10"
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                </textarea>

                                            </div>
                                        </div>

                                        <!-- Country Select -->
                                        <div class="sm:col-span-3">
                                            <label for="country"
                                                class="block text-sm font-medium leading-6 text-gray-900">Country</label>
                                            <div class="mt-2">
                                                <select id="country" name="country" autocomplete="country-name"
                                                    v-model="selectedCountry"
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                                    <option value="Norway">Norway</option>
                                                    <option value="Canada">Canada</option>
                                                    <option value="Mexico">Mexico</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Language Select -->
                                        <div class="sm:col-span-3">
                                            <label for="language"
                                                class="block text-sm font-medium leading-6 text-gray-900">Language</label>
                                            <div class="mt-2">
                                                <select id="language" name="language" autocomplete="language-name"
                                                    v-model="selectedLanguage"
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                                    <option value="no-nb">no-nb</option>
                                                    <option value="Language2">Language2</option>
                                                    <option value="Language3">Language3</option>
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

                                    <button type="submit"
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
    </AppLayout>
</template>

