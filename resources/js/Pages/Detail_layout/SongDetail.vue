<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { format } from 'date-fns';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from "@fortawesome/fontawesome-svg-core";
import { faCircleArrowLeft } from '@fortawesome/free-solid-svg-icons';

library.add(faCircleArrowLeft);

const song = usePage().props.data.song;

const nameInput = ref(null);
const albumInput = ref(null);
const artistInput = ref(null);

const form = useForm({
    id: song.id,
    name: song.name,
    album: song.album,
    artist: song.artist,
    artist_id: song.artist_id,
});
// console.log(song);
const title = song.name + " detail";

const songAnotherInfo = {
    'length': 'Length: ' + song.length,
    'uploaded_at': 'Uploaded at: ' + format(song.created_at, "dd/MM/yyyy HH:mm:ss")
};

const back = function () {
    window.history.back();
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
        <form @submit.prevent="form.post(route('songs.update', song.id))"
            class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mt-3">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput id="name" ref="nameInput" v-model="form.name" type="text" class="mt-1 block w-full"
                    autocomplete="" />

                <!-- <InputError :message="form.errors.current_password" class="mt-2" /> -->
            </div>

            <div>
                <InputLabel for="album" value="Album" />

                <TextInput id="album" ref="albumInput" v-model="form.album" type="text" class="mt-1 block w-full"
                    autocomplete="" />

                <!-- <InputError :message="form.errors.password" class="mt-2" /> -->
            </div>

            <div>
                <InputLabel for="artist" value="Artist" />

                <TextInput id="artist" ref="artistInput" v-model="form.artist" type="text" class="mt-1 block w-full"
                    autocomplete="" />

                <!-- <InputError :message="form.errors.password_confirmation" class="mt-2" /> -->
            </div>

            <InputLabel :value="songAnotherInfo.length" />
            <InputLabel :value="songAnotherInfo.uploaded_at" />

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
