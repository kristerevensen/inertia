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
    selectedTeamId: selectedTeam.value.id || null,
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

            </div>
        </template>




    </AppLayout>
</template>

