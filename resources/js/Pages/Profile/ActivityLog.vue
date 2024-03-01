<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from "@fortawesome/fontawesome-svg-core";
import { faChevronDown } from '@fortawesome/free-solid-svg-icons';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { format } from 'date-fns';
import { eventBus } from '@/eventBus.js';

const props = defineProps({
    data: {
        type: Object
    }
})

//icon
library.add(faChevronDown);

//date time processing
const formatDate = (date) => {
    return format(date, "HH:mm:ss");
}
// console.log(props.data);

const markAllAsRead = () => {
    router.get('/activity-log/mark-all-as-read');
    eventBus.emit('markAllAsRead');
}
</script>


<template>
    <Head title="Activity Log" />

    <AuthenticatedLayout>
        <template #header>
            <div class="grid grid-cols-13">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight col-span-8">Activity Log</h2>
                <div class="col-end-14 col-start-11">
                    <PrimaryButton @click="markAllAsRead()">Mark All as Read</PrimaryButton>
                </div>
            </div>
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pt-8 mx-10 grid grid-cols-3">
                <div v-for="activities, date in data" :key="date"
                    class="max-w-7xl mx-5 mb-5 w-90 p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ date }}</h5>
                    <Menu as="div" v-for="activity in activities">
                        <MenuButton
                            class="w-full text-left cursor-pointer hover:bg-gray-100">
                            <span class="font-normal text-gray-700 dark:text-gray-400 w-full">{{ formatDate(activity.created_at) }} - {{
                                activity.data.message }}</span>
                            <font-awesome-icon class="float-right inline-block" icon="fa-solid fa-chevron-down fa-xs" />
                            <br>

                            <transition enter-active-class="transition ease-out duration-100"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95">
                                <MenuItems
                                    class="absolute mt-2 w-30 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <div class="py-1">
                                        <MenuItem v-slot="{ active }" v-for="detail in activity.data.data">
                                        <span
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">{{ detail }}
                                        </span>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </MenuButton>
                    </Menu>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
