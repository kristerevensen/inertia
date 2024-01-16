<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Pagination from "@/Components/Paginator.vue";
import { ref, reactive } from "vue";
import { Link, router, useForm } from "@inertiajs/vue3";
import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions, Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { } from '@headlessui/vue'
import { CheckIcon, ChevronUpDownIcon, ChevronDownIcon, LinkIcon, PlusIcon, QuestionMarkCircleIcon } from '@heroicons/vue/20/solid'
import {
    CalendarIcon,
    ChartPieIcon,
    DocumentDuplicateIcon,
    FolderIcon,
    HomeIcon,
    UsersIcon,
    XMarkIcon
} from '@heroicons/vue/24/outline'


const props = defineProps({
    projects: Object,
    teamsProject: Object,
    errors: Object,
});

const selectedTeam = ref(props.teamsProject[0]);
//const selectedTeam = ref(teamsProject.value.data[0]);
const openDialog = ref(false);
let processesing = ref(false);


const form = useForm({
    form_search: null,
    projectName: '',
    description: '',
    selectedTeamId: '',
    domain: '',
});

console.log(form);


let submit = () => {
    // Add the selected team's ID to the form data
    form.data.selectedTeamId = selectedTeam.value.id; // Update the selected team ID
    form.post("/project/store");
    processesing.value = true;
    form.reset();
}


</script>


<template>
    <AppLayout title="Dashboard">
        <template #header>
            <div class="flex justify-between">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Projects
                    </h2>
                </div>
                <div>
                    <button type="button"
                        class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        @click="openDialog = true">
                        Add Project
                    </button>
                </div>
            </div>
        </template>

        <template>
            <TransitionRoot as="template" :show="openDialog">
                <Dialog as="div" class="relative z-10" @close="openDialog = false">
                    <div class="fixed inset-0" />

                    <div class="fixed inset-0 overflow-hidden">
                        <div class="absolute inset-0 overflow-hidden">
                            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10 sm:pl-16">
                                <TransitionChild as="template"
                                    enter="transform transition ease-in-out duration-500 sm:duration-700"
                                    enter-from="translate-x-full" enter-to="translate-x-0"
                                    leave="transform transition ease-in-out duration-500 sm:duration-700"
                                    leave-from="translate-x-0" leave-to="translate-x-full">
                                    <DialogPanel class="pointer-events-auto w-screen max-w-md">

                                        <form class="flex h-full flex-col divide-y divide-gray-200 bg-white shadow-xl"
                                            @submit.prevent="submit">
                                            <div class="h-0 flex-1 overflow-y-auto">
                                                <div class="bg-indigo-700 px-4 py-6 sm:px-6">
                                                    <div class="flex items-center justify-between">
                                                        <DialogTitle class="text-base font-semibold leading-6 text-white">
                                                            New Project</DialogTitle>
                                                        <div class="ml-3 flex h-7 items-center">
                                                            <button type="button"
                                                                class="relative rounded-md bg-indigo-700 text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                                                                @click="openDialog = false">
                                                                <span class="absolute -inset-2.5" />
                                                                <span class="sr-only">Close panel</span>
                                                                <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="mt-1">
                                                        <p class="text-sm text-indigo-300">Get started by filling in the
                                                            information below to create your new project.</p>
                                                    </div>
                                                </div>

                                                <div class="flex flex-1 flex-col justify-between">
                                                    <div class="divide-y divide-gray-200 px-4 sm:px-6">
                                                        <div class="space-y-6 pb-5 pt-6">
                                                            <div>
                                                                <label for="project-name"
                                                                    class="block text-sm font-medium leading-6 text-gray-900">Project
                                                                    name</label>
                                                                <div class="mt-2">
                                                                    <input type="text" v-model="form.projectName"
                                                                        name="project-name" id="project-name" required
                                                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                                                </div>
                                                                <div v-if="form.errors.projectName"
                                                                    v-text="form.errors.projectName"
                                                                    class="text-red-500 text-xs mt-1"></div>
                                                            </div>
                                                            <div>
                                                                <label for="description"
                                                                    class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                                                                <div class="mt-2">
                                                                    <textarea id="description"
                                                                        v-model="form.projectDescription" name="description"
                                                                        rows="4"
                                                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                                                </div>
                                                                <div v-if="form.errors.projectDescription"
                                                                    v-text="form.errors.projectDescription"
                                                                    class="text-red-500 text-xs mt-1"></div>
                                                            </div>
                                                            <div>
                                                                <label for="project-name"
                                                                    class="block text-sm font-medium leading-6 text-gray-900">Domain</label>
                                                                <div
                                                                    class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                                                    <span
                                                                        class="flex select-none items-center pl-3 text-gray-500 sm:text-sm">http://</span>
                                                                    <input type="text" id="domain" v-model="form.domain"
                                                                        name="domain" required
                                                                        class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                                                        placeholder="example.com" />
                                                                </div>
                                                                <div v-if="form.errors.domain" v-text="form.errors.domain"
                                                                    class="text-red-500 text-xs mt-1"></div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="flex flex-1 flex-col justify-between">
                                                        <div class="divide-y divide-gray-200 px-4 sm:px-6">
                                                            <div class="space-y-6 pb-5 pt-6">
                                                                <Listbox as="div" v-model="selectedTeam">
                                                                    <ListboxLabel
                                                                        class="block text-sm font-medium leading-6 text-gray-900">
                                                                        Assigned to team</ListboxLabel>
                                                                    <div class="relative mt-2">
                                                                        <ListboxButton
                                                                            class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                                            <span class="block truncate">{{
                                                                                selectedTeam.name }}</span>
                                                                            <span
                                                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                                                                <ChevronUpDownIcon
                                                                                    class="h-5 w-5 text-gray-400"
                                                                                    aria-hidden="true" />
                                                                            </span>
                                                                        </ListboxButton>

                                                                        <transition
                                                                            leave-active-class="transition ease-in duration-100"
                                                                            leave-from-class="opacity-100"
                                                                            leave-to-class="opacity-0">
                                                                            <ListboxOptions
                                                                                class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                                                                <ListboxOption as="template"
                                                                                    v-for="tp in teamsProject" :key="tp.id"
                                                                                    :value="tp"
                                                                                    v-slot="{ active, selectedTeam }">
                                                                                    <li
                                                                                        :class="[active ? 'bg-indigo-600 text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                                                                                        <span
                                                                                            :class="[selectedTeam ? 'font-semibold' : 'font-normal', 'block truncate']">{{
                                                                                                tp.name }}</span>

                                                                                        <span v-if="selectedTeam"
                                                                                            :class="[active ? 'text-white' : 'text-indigo-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                                                                                            <CheckIcon class="h-5 w-5"
                                                                                                aria-hidden="true" />
                                                                                        </span>
                                                                                    </li>
                                                                                </ListboxOption>
                                                                            </ListboxOptions>
                                                                        </transition>
                                                                    </div>
                                                                </Listbox>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex flex-shrink-0 justify-end px-4 py-4">
                                                <button type="button"
                                                    class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                                                    @click="openDialog = false">Cancel</button>
                                                <button type="submit" :disabled="processesing"
                                                    class="ml-4 inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                                            </div>
                                        </form>
                                    </DialogPanel>
                                </TransitionChild>
                            </div>
                        </div>
                    </div>
                </Dialog>
            </TransitionRoot>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px lg:px-0">
                <div class="sm:px-6 lg:px-8">

                    <div class="mt-0 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">


                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                            <tr>

                                                <th scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                    Name
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    Domain
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    Team
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    Language
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    Country
                                                </th>
                                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                    Settings
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                            <tr v-for="project in projects.data" :key="project.id">
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                    <b>{{ project.name }}</b>
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {{ project.domain }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {{ project.team_name }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {{ project.language }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {{ project.country }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text flex justify-center">
                                                    <a :href="`/project/${project.project_code}/edit`"
                                                        class=" rounded bg-indigo-600 px-2 py-1 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">View</a>
                                                </td>
                                            </tr>

                                            <!-- More people... -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <Pagination :links="projects.links" class="mt-6" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

