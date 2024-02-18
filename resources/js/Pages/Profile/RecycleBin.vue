<script setup>
import AudioComponent from '@/Components/AudioComponent.vue';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from "@fortawesome/fontawesome-svg-core";
import { faEllipsisVertical, faCircleArrowLeft } from '@fortawesome/free-solid-svg-icons';
import { router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { format } from 'date-fns';
import PrimaryButton from '@/Components/PrimaryButton.vue';

library.add(faEllipsisVertical, faCircleArrowLeft);

defineProps({
    trashedSongs: {
        type: Array
    },
    totalDeletedSongs: {
        type: Number
    }
})

defineOptions({
    layout: AudioComponent
})

const restoreSong = function (id) {
    if (confirm('Are you sure you want to restore this song?')) {
        router.post(`/recycle-bin/restore/${id}`, {
            onFinish: () => window.location.reload()
        })
    }
}

const permaDeleteSong = function (id) {
    router.delete(`/recycle-bin/delete/${id}`, {
        onBefore: () => confirm('Are you sure you want to permanently delete this song?'),
        onFinish: () => window.location.reload()
    })
}

const restoreAll = function () {
    if (confirm('Are you sure you want to restore all song?')) {
        router.post(`/recycle-bin/restore-all`, {
            onFinish: () => window.location.reload()
        })
    }
}

const deleteAll = function () {
    router.delete(`/recycle-bin/delete-all`, {
        onBefore: () => confirm('Are you sure you want to empty the recycle bin? This action cannot be undone and all your deleted songs will be lost!'),
        onFinish: () => window.location.reload()
    })
}

</script>

<template>
    <Head title="Music App" />

    <AuthenticatedLayout>
        <template #header>
            <div class="grid grid-cols-13">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight col-span-8">Recently Deleted Songs ({{ totalDeletedSongs
                }})</h2>
                <div class="col-end-14 col-start-11">
                    <PrimaryButton @click="restoreAll()">Restore All</PrimaryButton>
                    <PrimaryButton @click="deleteAll()">Empty Recycle Bin</PrimaryButton>
                </div>
            </div>
        </template>
        <div>
            <div class="grid grid-cols-2 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="pt-8 mx-10" v-for="song in trashedSongs">
                    <div class="max-w-xl mx-0 pr-0 sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-3 text-gray-900">
                                <div class="grid grid-cols-12">
                                    <div class="col-span-11 item-center py-2">
                                        <div class="text-xl overflow-hidden">{{ song.name }} </div>
                                        <div class="text-l italic overflow-hidden text-gray-500">(deleted_at {{
                                            format(song.deleted_at, "dd/MM/yyyy HH:mm:ss") }})</div>
                                        <div class="text-sm text-gray-500"><span v-for="artist, index in song.artists"
                                                :key="index">
                                                <span v-if="index != 0">, </span>{{ artist.artists }}</span>
                                            <span v-if="song.album"> - {{ song.album }}</span>
                                        </div>
                                    </div>
                                    <div class="item-center px-2">
                                        <Menu as="div" class="inline-block text-left">
                                            <div>
                                                <MenuButton
                                                    class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                                    <font-awesome-icon icon="ellipsis-vertical" />
                                                </MenuButton>
                                            </div>

                                            <transition enter-active-class="transition ease-out duration-100"
                                                enter-from-class="transform opacity-0 scale-95"
                                                enter-to-class="transform opacity-100 scale-100"
                                                leave-active-class="transition ease-in duration-75"
                                                leave-from-class="transform opacity-100 scale-100"
                                                leave-to-class="transform opacity-0 scale-95">
                                                <MenuItems
                                                    class="absolute mt-2 w-30 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                    <div class="py-1">
                                                        <MenuItem v-slot="{ active }">
                                                        <a :href="route('recycle-bin.detail', song.id)"
                                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Details
                                                        </a>
                                                        </MenuItem>
                                                        <MenuItem v-slot="{ active }">
                                                        <a @click="restoreSong(song.id)" style="cursor: pointer;"
                                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Restore</a>
                                                        </MenuItem>
                                                        <MenuItem v-slot="{ active }">
                                                        <a @click="permaDeleteSong(song.id)" style="cursor: pointer;"
                                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Permanently
                                                            Delete</a>
                                                        </MenuItem>
                                                    </div>
                                                </MenuItems>
                                            </transition>
                                        </Menu>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout></template>
