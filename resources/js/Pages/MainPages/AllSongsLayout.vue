<script setup>
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from "@fortawesome/fontawesome-svg-core";
import { faEllipsisVertical } from '@fortawesome/free-solid-svg-icons';
import { router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { inject } from 'vue';
import { eventBus } from '@/eventBus.js';

library.add(faEllipsisVertical);

const props = defineProps({
    songs: {
        type: Array
    },
    totalSongs: {
        type: Number
    }
})

// const emit = defineEmits(['playSong']);

const deleteSong = function (id) {
    router.delete(`/songs/delete/${id}`, {
        onBefore: () => confirm('Are you sure you want to delete this song?'),
        onFinish: () => window.location.reload()
    })
}

const addSong = function () {
    router.get('/songs/add')
}

const playSong = function (song, index) {
    if (typeof song.song_path != undefined) {
        if (localStorage.getItem('currentPlaylist') != null && localStorage.getItem('currentSong') != null) {
            localStorage.removeItem('currentPlaylist');
        }

        localStorage.setItem('index', index);
        localStorage.setItem('currentPlaylist', JSON.stringify(props.songs));
        eventBus.emit('playSong', index);
        // document.getElementById('audio').play();
    }
}
</script>


<template>
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-13">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Songs (<span
                        v-if="totalSongs == 0">0</span>
                    <span v-else>{{ totalSongs }}</span>)
                </h2>
                <div class="col-end-16 col-start-13">
                    <PrimaryButton @click="addSong()" style="margin-right: 0 !important;">Add Songs</PrimaryButton>
                </div>
            </div>
        </div>
    </header>
    <div>
        <div class="grid grid-cols-2 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pt-8 mx-10" v-for="(song, index) in songs" :key="index">
                <div class="max-w-xl mx-0 pr-0 sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <button type="button" @click="playSong(song, index)" class="p-3 text-gray-900 text-left">
                            <div class="grid grid-cols-12">
                                <div class="col-span-11 item-center py-2">
                                    <div class="text-xl overflow-hidden">{{ song.name }}</div>
                                    <div class="text-sm"><span v-for="artist, index in song.artists" :key="index">
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
                                                    <a :href="route('songs.update', song.id)"
                                                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Details
                                                    </a>
                                                    </MenuItem>
                                                    <MenuItem v-slot="{ active }">
                                                    <a @click="deleteSong(song.id)" style="cursor: pointer;"
                                                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Move
                                                        to Recycle Bin</a>
                                                    </MenuItem>
                                                </div>
                                            </MenuItems>
                                        </transition>
                                    </Menu>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
