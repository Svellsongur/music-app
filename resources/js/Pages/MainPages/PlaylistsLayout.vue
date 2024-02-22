
<script setup>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from "@fortawesome/fontawesome-svg-core";
import { faEllipsisVertical, faPlus } from '@fortawesome/free-solid-svg-icons';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { router, useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'

library.add(faEllipsisVertical, faPlus);

defineProps({
    playlists: {
        type: Array
    }
})

const openModal = ref(false);
const nameInput = ref(null);

const form = useForm({
    name: '',
});


const addSong = function () {
    router.get('/songs/add')
}

//playlist
const openPlaylistModal = function () {
    openModal.value = true;

    nextTick(() => nameInput.value.focus());
}

const closeModal = function () {
    openModal.value = false;

    form.reset();
}

const addPlaylist = function () {
    if (form.name.value != '') {
        form.post('/playlists/add', {
            onFinish: () => {
                closeModal();
                router.get('/playlists');
            }
        })
    }
}

const deletePlaylist = function (id) {
    router.delete(`/playlists/delete/${id}`, {
        onFinish: () => window.location.reload()
    })
}

const detailPlaylist = function (id) {
    router.get(`/playlists/detail/${id}`)
}
</script>


<template>
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 pb-10">
            <div class="grid grid-cols-13">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Playlists</h2>
                <div class="col-end-16 col-start-13">
                    <PrimaryButton @click="addSong()" style="margin-right: 0 !important;">Add Songs</PrimaryButton>
                </div>
            </div>
        </div>
    </header>
    <div class="grid grid-cols-2 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="pt-8 mx-10" v-for="playlist in playlists">
            <div class="max-w-xl mx-0 pr-0 sm:px-6 lg:px-8 " @click="detailPlaylist(playlist.id)">
                <div class="bg-gray-300 overflow-hidden shadow-sm sm:rounded-lg">
                    <button class="p-3 text-gray-900 text-left">
                        <div class="grid grid-cols-12">
                            <div class="col-span-11 items-center py-2">
                                <div class="text-xl overflow-hidden">{{ playlist.name }}</div>
                            </div>
                            <div class="inline-flex w-full gap-x-1.5 px-2 py-2 text-sm font-semibold text-gray-900">
                                <Menu as="div" class="inline-block text-left" @click.stop>
                                    <div>
                                        <MenuButton
                                            class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-gray-300 px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300">
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
                                                <a @click="detailPlaylist(playlist.id)" style="cursor: pointer;"
                                                    :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Details
                                                </a>
                                                </MenuItem>
                                                <MenuItem v-slot="{ active }">
                                                <a @click="deletePlaylist(playlist.id)" style="cursor: pointer;"
                                                    :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Delete</a>
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
        <div class="pt-8 mx-10" @click="openPlaylistModal">
            <div class="max-w-xl mx-0 pr-0 sm:px-6 lg:px-8 ">
                <button class="w-full py-2 bg-white overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 text-center">
                    <div class="p-2 text-gray-900">
                        <div class="text-xl overflow-hidden">Add new playlist +</div>
                    </div>
                </button>
            </div>
        </div>
        <Modal :show="openModal" @close="closeModal()">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Add new playlist
                </h2>

                <div class="mt-6">
                    <InputLabel for="name" value="Name" class="sr-only" />

                    <TextInput id="name" type="text" ref="nameInput" v-model="form.name" class="mt-1 block w-3/4"
                        placeholder="Enter new playlist's name" @keyup.enter="addPlaylist()" />

                    <!-- <InputError :message="form.errors.password" class="mt-2" /> -->
                </div>

                <div class="mt-6 flex justify-end">
                    <PrimaryButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        @click="addPlaylist()">
                        Add new playlist
                    </PrimaryButton>
                    <SecondaryButton @click="closeModal()"> Cancel </SecondaryButton>
                </div>
            </div>
        </Modal>
    </div>
</template>
