<script setup>
import { Head, useForm, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from "@fortawesome/fontawesome-svg-core";
import { faCircleArrowLeft } from '@fortawesome/free-solid-svg-icons';
import Swal from 'sweetalert2';

library.add(faCircleArrowLeft);

const props = defineProps({
    title: String,
    songs: Array,
    playlist_id: String
})

const form = useForm({
    song_id: [],
});

const back = function () {
    window.history.back();
}

const submit = function () {
    form.post(`/playlists/add-songs-to-playlist/${props.playlist_id}`, {
        onSuccess: () => {
            Swal.fire({
                title: 'Success!',
                text: 'Added songs to playlist successfully!',
                icon: 'success',
                confirmButtonText: 'Ok'
            });
            router.get('/playlists/detail/' + props.playlist_id);
        }
    })
}
</script>

<template>
    <Head :title="title" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ title }}</h2>
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-3">
            <button @click="back()">
                <font-awesome-icon class="mx-auto mt-3" icon="fa-solid fa-circle-arrow-left" size="xl"
                    style="cursor:pointer" />
            </button>
        </div>
        <form @submit.prevent="submit()" class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mt-3">
            <div class="grid grid-cols-4">
                <div v-for="song in songs">
                    <div class="flex items-center mb-4">
                        <input id="default-checkbox" type="checkbox" :value="song.id" v-model="form.song_id"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="default-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{
                            song.name }}</label>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Add</PrimaryButton>

                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Added.</p>
                </Transition>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
