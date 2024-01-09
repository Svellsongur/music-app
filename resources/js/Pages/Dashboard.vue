<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import MusicTabPane from '@/Components/MusicTabPane.vue';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <MusicTabPane :href="route('dashboard')" :active="route().current('dashboard')">
                                Dashboard
                            </MusicTabPane>
                            <MusicTabPane :href="route('dashboard')" :active="route().current('dashboard')">
                                Abc
                            </MusicTabPane>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
