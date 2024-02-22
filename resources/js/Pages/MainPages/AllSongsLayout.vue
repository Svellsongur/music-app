<script setup>
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from "@fortawesome/fontawesome-svg-core";
import { faEllipsisVertical, faCircleArrowLeft } from '@fortawesome/free-solid-svg-icons';
import { router, usePage } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { eventBus } from '@/eventBus.js';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import { ref, toRef } from 'vue';

library.add(faEllipsisVertical, faCircleArrowLeft);

const props = defineProps({
    data: {
        type: Object
    }
})

let songs = props.data.songs;
let totalSongs = props.data.totalSongs;
let title = props.data.title;
let type = props.data.layoutType;
let allSongs = usePage().props.auth.allSongs;
let playlists = usePage().props.auth.playlists;

const deleteSong = function (id) {
    router.delete(`/songs/delete/${id}`, {
        onBefore: () => confirm('Are you sure you want to move this song to recycle bin? You can restore it later'),
        onFinish: () => window.location.reload()
    })
}

const addSong = function () {
    router.get('/songs/add')
}

const playSong = function (song, index) {
    if (typeof song.song_path != undefined) {
        if (localStorage.getItem('currentPlaylist') != null) {
            localStorage.removeItem('currentPlaylist');
        }

        localStorage.setItem('index', index);
        localStorage.setItem('currentPlaylist', JSON.stringify(props.data.songs));
        eventBus.emit('playSong', index);
    }
}

//modal functions
let openModal = ref(false);
let showBackBtn = false;
let openAllPlaylist = ref(false);

const openAllPlaylistModal = function () {
    openAllPlaylist.value = true;
}

const closeAllPlaylistModal = function () {
    openAllPlaylist.value = false;
}

if (type != 1) {
    showBackBtn = true;
}
const closeModal = function () {
    openModal.value = false;
}

const addSongToPlaylist = function (id) {
    openModal.value = true;
}

//except all songs layout
const back = function () {
    window.history.back();
}
</script>
<template>
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-13">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ title }} (<span
                        v-if="totalSongs == 0">0</span>
                    <span v-else>{{ totalSongs }}</span>)
                </h2>
                <div class="col-end-16 col-start-13">
                    <PrimaryButton @click="addSong()" style="margin-right: 0 !important;">Add Songs</PrimaryButton>
                </div>
            </div>
        </div>
    </header>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-3">
        <button @click="back()" v-show="showBackBtn">
            <font-awesome-icon class="mx-auto mt-3" icon="fa-solid fa-circle-arrow-left" size="xl" style="cursor:pointer" />
        </button>
    </div>
    <div class="pb-10">
        <div class="grid grid-cols-3 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pt-8 mx-0" v-for="(song, index) in songs" :key="index">
                <div class="max-w-xl mx-0 pr-0 sm:px-6 lg:px-8">
                    <div class="bg-gray-300 overflow-hidden shadow-sm sm:rounded-lg">
                        <button type="button" @click="playSong(song, index)" class="p-3 text-gray-900 text-left">
                            <div class="grid grid-cols-12" v-for="artist, index in song.artists" :key="index">
                                <div class="col-span-11 item-center py-2"
                                    :title="song.name + ' - ' + artist.artists + (song.album ? ' - ' + song.album : '')">
                                    <div class="text-xl overflow-hidden">{{ song.name }}</div>
                                    <div class="text-sm truncate"><span>
                                            <span v-if="index != 0">, </span>{{ artist.artists }}</span>
                                        <span v-if="song.album"> - {{ song.album }}</span>
                                    </div>
                                </div>
                                <div class="item-center px-2" @click.stop id="dropdownButton">
                                    <Menu as="div" class="inline-block text-left">
                                        <div>
                                            <MenuButton
                                                class="bg-gray-300 rounded-xl inline-flex w-full justify-center gap-x-1.5 rounded-md px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-300">
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
                                                class="absolute bg-white mt-2 w-30 origin-top-right rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                <div class="py-1">
                                                    <MenuItem v-slot="{ active }">
                                                    <a :href="route('songs.update', song.id)"
                                                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-xs']">Details
                                                    </a>
                                                    </MenuItem>
                                                    <MenuItem v-slot="{ active }">
                                                    <a @click="deleteSong(song.id)" style="cursor: pointer;"
                                                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-xs']">Move
                                                        to Recycle Bin</a>
                                                    </MenuItem>
                                                    <MenuItem v-slot="{ active }">
                                                    <a @click="openAllPlaylistModal()" style="cursor: pointer;"
                                                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-xs']">Add
                                                        to playlist</a>
                                                    </MenuItem>
                                                    <MenuItem v-if="type == 3" v-slot="{ active }">
                                                    <a @click="removeFromPlaylist(song.id)" style="cursor: pointer;"
                                                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-xs']">Remove
                                                        from this playlist</a>
                                                    </MenuItem>
                                                </div>
                                            </MenuItems>
                                        </transition>
                                    </Menu>

                                    <Modal :show="openAllPlaylist" @close="closeAllPlaylistModal">
                                        <div class="p-6">
                                            <div class="text-lg font-medium text-gray-900">Choose Playlists</div>
                                            <div class="mt-6 grids grid-cols-2">
                                                <div class="flex items-center mb-4" v-for="playlist in playlists">
                                                    <input id="default-radio-1" type="radio" value="" name="default-radio"
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                    <label for="default-radio-1"
                                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 text-truncate">{{
                                                            playlist.name }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="mt-6 flex justify-end">
                                                <SecondaryButton @click="closeAllPlaylistModal()"> Cancel </SecondaryButton>
                                            </div>
                                        </div>
                                    </Modal>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
            <div class="pt-8 mx-10" v-if="type == 3" @click="openAddToPlaylistModal()">
                <div class="max-w-xl mx-0 pr-0 sm:px-6 lg:px-8 ">
                    <button
                        class="w-full py-2 bg-gray-300 overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 text-center">
                        <div class="p-2 text-gray-900">
                            <div class="text-xl overflow-hidden">Add new playlist +</div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
