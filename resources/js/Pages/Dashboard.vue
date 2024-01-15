<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Pagination from "@/Components/Paginator.vue";
import { ref, reactive } from "vue";
import { Link, router } from "@inertiajs/vue3";
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { XMarkIcon } from '@heroicons/vue/24/outline'
import { LinkIcon, PlusIcon, QuestionMarkCircleIcon } from '@heroicons/vue/20/solid'

 defineProps({
    projects: Object,
});


const form = reactive({
    form_search: null,
});

function submit() {
    router.post("/Dashboard", form);
}


const team = [
  {
    name: 'Tom Cook',
    email: 'tom.cook@example.com',
    href: '#',
    imageUrl:
      'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
  },
  {
    name: 'Whitney Francis',
    email: 'whitney.francis@example.com',
    href: '#',
    imageUrl:
      'https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
  },
  {
    name: 'Leonard Krasner',
    email: 'leonard.krasner@example.com',
    href: '#',
    imageUrl:
      'https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
  },
  {
    name: 'Floyd Miles',
    email: 'floyd.miles@example.com',
    href: '#',
    imageUrl:
      'https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
  },
  {
    name: 'Emily Selman',
    email: 'emily.selman@example.com',
    href: '#',
    imageUrl:
      'https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
  },
]

const open = ref(true)
const openDialog = ref(false);
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
            <TransitionChild as="template" enter="transform transition ease-in-out duration-500 sm:duration-700" enter-from="translate-x-full" enter-to="translate-x-0" leave="transform transition ease-in-out duration-500 sm:duration-700" leave-from="translate-x-0" leave-to="translate-x-full">
              <DialogPanel class="pointer-events-auto w-screen max-w-md">
                <form class="flex h-full flex-col divide-y divide-gray-200 bg-white shadow-xl">
                  <div class="h-0 flex-1 overflow-y-auto">
                    <div class="bg-indigo-700 px-4 py-6 sm:px-6">
                      <div class="flex items-center justify-between">
                        <DialogTitle class="text-base font-semibold leading-6 text-white">New Project</DialogTitle>
                        <div class="ml-3 flex h-7 items-center">
                          <button type="button" class="relative rounded-md bg-indigo-700 text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white" @click="openDialog = false">
                            <span class="absolute -inset-2.5" />
                            <span class="sr-only">Close panel</span>
                            <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                          </button>
                        </div>
                      </div>
                      <div class="mt-1">
                        <p class="text-sm text-indigo-300">Get started by filling in the information below to create your new project.</p>
                      </div>
                    </div>
                    <div class="flex flex-1 flex-col justify-between">
                      <div class="divide-y divide-gray-200 px-4 sm:px-6">
                        <div class="space-y-6 pb-5 pt-6">
                          <div>
                            <label for="project-name" class="block text-sm font-medium leading-6 text-gray-900">Project name</label>
                            <div class="mt-2">
                              <input type="text" name="project-name" id="project-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                            </div>
                          </div>
                          <div>
                            <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                            <div class="mt-2">
                              <textarea id="description" name="description" rows="4" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                            </div>
                          </div>
                          <div>
                            <h3 class="text-sm font-medium leading-6 text-gray-900">Team Members</h3>
                            <div class="mt-2">
                              <div class="flex space-x-2">
                                <a v-for="person in team" :key="person.email" :href="person.href" class="relative rounded-full hover:opacity-75">
                                  <img class="inline-block h-8 w-8 rounded-full" :src="person.imageUrl" :alt="person.name" />
                                </a>
                                <button type="button" class="relative inline-flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full border-2 border-dashed border-gray-200 bg-white text-gray-400 hover:border-gray-300 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                  <span class="absolute -inset-2" />
                                  <span class="sr-only">Add team member</span>
                                  <PlusIcon class="h-5 w-5" aria-hidden="true" />
                                </button>
                              </div>
                            </div>
                          </div>
                          <fieldset>
                            <legend class="text-sm font-medium leading-6 text-gray-900">Privacy</legend>
                            <div class="mt-2 space-y-4">
                              <div class="relative flex items-start">
                                <div class="absolute flex h-6 items-center">
                                  <input id="privacy-public" name="privacy" aria-describedby="privacy-public-description" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600" checked="" />
                                </div>
                                <div class="pl-7 text-sm leading-6">
                                  <label for="privacy-public" class="font-medium text-gray-900">Public access</label>
                                  <p id="privacy-public-description" class="text-gray-500">Everyone with the link will see this project.</p>
                                </div>
                              </div>
                              <div>
                                <div class="relative flex items-start">
                                  <div class="absolute flex h-6 items-center">
                                    <input id="privacy-private-to-project" name="privacy" aria-describedby="privacy-private-to-project-description" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                                  </div>
                                  <div class="pl-7 text-sm leading-6">
                                    <label for="privacy-private-to-project" class="font-medium text-gray-900">Private to project members</label>
                                    <p id="privacy-private-to-project-description" class="text-gray-500">Only members of this project would be able to access.</p>
                                  </div>
                                </div>
                              </div>
                              <div>
                                <div class="relative flex items-start">
                                  <div class="absolute flex h-6 items-center">
                                    <input id="privacy-private" name="privacy" aria-describedby="privacy-private-to-project-description" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                                  </div>
                                  <div class="pl-7 text-sm leading-6">
                                    <label for="privacy-private" class="font-medium text-gray-900">Private to you</label>
                                    <p id="privacy-private-description" class="text-gray-500">You are the only one able to access this project.</p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </fieldset>
                        </div>
                        <div class="pb-6 pt-4">
                          <div class="flex text-sm">
                            <a href="#" class="group inline-flex items-center font-medium text-indigo-600 hover:text-indigo-900">
                              <LinkIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-900" aria-hidden="true" />
                              <span class="ml-2">Copy link</span>
                            </a>
                          </div>
                          <div class="mt-4 flex text-sm">
                            <a href="#" class="group inline-flex items-center text-gray-500 hover:text-gray-900">
                              <QuestionMarkCircleIcon class="h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                              <span class="ml-2">Learn more about sharing</span>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="flex flex-shrink-0 justify-end px-4 py-4">
                    <button type="button" class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50" @click="open = false">Cancel</button>
                    <button type="submit" class="ml-4 inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
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

                                <div>
                                    <form @submit.prevent="submit">
                                        <div class="flex justify-between ">
                                            <div>
                                                <input v-model="form.search" id="search"
                                                    class="block mb-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                    placeholder="Search..." />
                                            </div>

                                            <div>
                                                <button
                                                    class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                                    type="submit">Submit</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="relative px-7 sm:w-12 sm:px-6">
                                                    <input type="checkbox"
                                                        class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                                                </th>
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
                                                    Language
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    Country
                                                </th>
                                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                    <span class="sr-only">Edit</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                            <tr v-for="project in projects.data" :key="project.id">
                                                <td class="relative px-7 sm:w-12 sm:px-6">
                                                    <!-- Selected row marker, only show when row is selected. -->
                                                    <!-- <div class="absolute inset-y-0 left-0 w-0.5 bg-indigo-600"></div> -->

                                                    <input type="checkbox" value="{{ project.id }}"
                                                        class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                                                </td>
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                    {{ project.name }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {{ project.domain }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {{ project.language }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {{ project.country }}
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
                            </div>
                        </div>
                    </div>
                    <Pagination :links="projects.links" class="mt-6" />
                </div>
            </div>
        </div>
    </AppLayout>
    </template>

