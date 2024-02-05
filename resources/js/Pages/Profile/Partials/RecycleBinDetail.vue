<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { format } from 'date-fns';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from "@fortawesome/fontawesome-svg-core";
import { faCircleArrowLeft } from '@fortawesome/free-solid-svg-icons';
import { router } from '@inertiajs/vue3';

library.add(faCircleArrowLeft);
const song = usePage().props.data.song;

// console.log(song);

const nameInput = ref(null);
const albumInput = ref(null);
const artistInput = ref(null);

// console.log(song);
const title = song.name + " detail";

const songAnotherInfo = {
    'deleted_at': format(song.deleted_at, "dd/MM/yyyy HH:mm:ss"),
    'uploaded_at': format(song.created_at, "dd/MM/yyyy HH:mm:ss")
};

const back = function () {
    router.get('/recycle-bin')
}

const restoreSong = function (id) {
    if (confirm('Are you sure you want to restore this song?')) {
        router.post(`/recycle-bin/restore/${id}`, {
            onSuccess: () => alert('Song restored!'),
            onFinish: () => window.location.reload()
        })
    }
}

</script>

<template>
    <Head :title="title" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ title }}</h2>
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-3">
            <button  @click="back()">
                <font-awesome-icon class="mx-auto mt-3" icon="fa-solid fa-circle-arrow-left" size="xl"
                    style="cursor:pointer" />
            </button>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-3 grid grid-cols-2">
            <div class="mt-3">
                <InputLabel for="name" value="Name:" />

                <span id="name" ref="nameInput" class="mt-1 block w-full">{{ song.name }}</span>

                <!-- <InputError :message="form.errors.current_password" class="mt-2" /> -->
            </div>

            <div class="mt-3">
                <InputLabel for="album" value="Album:" />

                <span id="album" ref="albumInput" class="block w-full" autocomplete="">{{ song.album
                }}</span>

                <!-- <InputError :message="form.errors.password" class="mt-2" /> -->
            </div>

            <div class="mt-3">
                <InputLabel for="artist" value="Artist:" />

                <span id="artist" ref="artistInput" class="block w-full" autocomplete=""><span
                        v-for="artist, index in song.artists" :key="index">
                        <span v-if="index != 0">, </span>{{ artist.artists }}</span></span>

                <!-- <InputError :message="form.errors.password_confirmation" class="mt-2" /> -->
            </div>
            <div class="mt-3">
                <InputLabel for="uploaded_at" value="Uploaded at:" />

                <span id="uploaded_at" class="block w-full" autocomplete="">{{ songAnotherInfo.uploaded_at }}</span>
            </div>

            <div class="mt-3">
                <InputLabel for="deleted_at" value="Deleted at:" />

                <span id="deleted_at" class="block w-full" autocomplete="">{{ songAnotherInfo.deleted_at }}</span>
            </div>

        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-3">
            <PrimaryButton @click="restoreSong(song.id)">Restore</PrimaryButton>
            <PrimaryButton @click="deleteSong(song.id)">Delete</PrimaryButton>
        </div>
    </AuthenticatedLayout>
</template>
