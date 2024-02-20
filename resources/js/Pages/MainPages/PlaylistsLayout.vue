
<script setup>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from "@fortawesome/fontawesome-svg-core";
import { faChevronRight, faPlus } from '@fortawesome/free-solid-svg-icons';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { router, useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';

library.add(faChevronRight, faPlus);

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
    form.post('/playlists/add', {
        onFinish: () => {
            closeModal();
            router.get('/playlists');
        }
    })
}
</script>


<template>
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
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
            <div class="max-w-xl mx-0 pr-0 sm:px-6 lg:px-8 ">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50">
                    <button class="p-3 text-gray-900 text-left">
                        <div class="grid grid-cols-12">
                            <div class="col-span-11 items-center py-2">
                                <div class="text-xl overflow-hidden">{{ playlist.name }}</div>
                            </div>
                            <div class="inline-flex w-full gap-x-1.5 px-7 py-4 text-sm font-semibold text-gray-900">
                                <font-awesome-icon icon="chevron-right" />
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
        <div class="pt-8 mx-10" @click="openPlaylistModal()">
            <div class="max-w-xl mx-0 pr-0 sm:px-6 lg:px-8 ">
                <button class="w-full py-2 bg-white overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 text-center">
                    <div class="p-3 text-gray-900">
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

                    <TextInput id="name" ref="nameInput" v-model="form.name" type="text" class="mt-1 block w-3/4"
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
