<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faMusic, faList, faRecordVinyl, faUser } from '@fortawesome/free-solid-svg-icons';
import { usePage } from '@inertiajs/vue3';
import { eventBus } from '@/eventBus.js';

//import icon
library.add(faMusic, faList, faRecordVinyl, faUser);

const showingNavigationDropdown = ref(false);

//logo
const logo = usePage().props.auth.logo;

//notification activity log
const showDot = ref(usePage().props.auth.showDot);

Echo.channel('private-music-app-lavender' + usePage().props.auth.user.id).listen('.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', (data) => {
    showDot.value = true;
})

eventBus.on('markAllAsRead', () => {
    showDot.value = false
})

</script>

<template>
    <div class="min-h-screen bg-gray-200">
        <nav class="bg-white border-b border-gray-100">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <Link :href="route('dashboard')">
                            <ApplicationLogo v-model="logo" class="block h-9 w-auto fill-current text-gray-800" />
                            </Link>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                <font-awesome-icon class="me-2" style="color: ;" icon="fa-solid fa-music" />
                                My Songs
                            </NavLink>
                            <NavLink :href="route('playlists')" :active="route().current('playlists')">
                                <font-awesome-icon class="me-2" style="color: ;" icon="fa-solid fa-list" />
                                My Playlists
                            </NavLink>
                            <NavLink :href="route('albums')" :active="route().current('albums')">
                                <font-awesome-icon class="me-2" style="color: ;" icon="record-vinyl" />
                                Albums
                            </NavLink>
                            <NavLink :href="route('artists')" :active="route().current('artists')">
                                <font-awesome-icon class="me-2" style="color: ;" icon="user" />
                                Artists
                            </NavLink>
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <!-- Settings Dropdown -->
                        <div class="ms-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                            <!-- {{ $page.props.auth.user.name }} -->
                                            <img :src="$page.props.auth.user_avatar" class="w-10 h-10 rounded-full">
                                            <span class="h-7" v-show="showDot">
                                                <div
                                                    class="items-center w-3 h-3 bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">
                                                </div>
                                            </span>
                                            <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                                    <DropdownLink :href="route('recycle-bin')"> Recycle Bin </DropdownLink>
                                    <DropdownLink :href="route('activity-log')" class="inline-flex">
                                        Activity log
                                        <span class="h-5" v-show="showDot">
                                            <div
                                                class="items-center w-3 h-3 bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">
                                            </div>
                                        </span>
                                    </DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button">
                                        Log Out
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{
                                    hidden: showingNavigationDropdown,
                                    'inline-flex': !showingNavigationDropdown,
                                }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{
                                    hidden: !showingNavigationDropdown,
                                    'inline-flex': showingNavigationDropdown,
                                }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                        Dashboard
                    </ResponsiveNavLink>
                </div>

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="px-4">
                        <div class="font-medium text-base text-gray-800">
                            {{ $page.props.auth.user.name }}
                        </div>
                        <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('recycle-bin')"> Recycle Bin </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                            Log Out
                        </ResponsiveNavLink>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <header class="bg-white shadow" v-if="$slots.header">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <!-- Page Content -->
        <main>
            <slot />
        </main>
    </div>
</template>
