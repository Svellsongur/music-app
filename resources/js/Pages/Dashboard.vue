<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import AllSongsLayout from '@/Layouts/AllSongsLayout.vue';
import PlaylistsLayout from '@/Layouts/PlaylistsLayout.vue';

const data = usePage().props.data;


</script>

<template>
    <Head title="Music App" />

    <AuthenticatedLayout>
        <AllSongsLayout v-if="data.songs" :songs="data.songs" />
        <PlaylistsLayout v-if="data.playlists" :playlists="data.playlists" />
    </AuthenticatedLayout>
</template>
