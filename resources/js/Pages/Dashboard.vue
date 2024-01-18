<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import AllSongsLayout from '@/Pages/MainPages/AllSongsLayout.vue';
import PlaylistsLayout from '@/Pages/MainPages/PlaylistsLayout.vue';
import ArtistsLayout from '@/Pages/MainPages/ArtistsLayout.vue';
import AlbumsLayout from '@/Pages/MainPages/AlbumsLayout.vue';


const data = usePage().props.data;
// console.log(data.songs);

</script>

<template>
    <Head title="Music App" />

    <AuthenticatedLayout>
        <AllSongsLayout v-if="data.songs" :songs="data.songs" />
        <PlaylistsLayout v-if="data.playlists" :playlists="data.playlists" />
        <ArtistsLayout v-if="data.artists" :artists="data.artists" />
        <AlbumsLayout v-if="data.albums" :albums="data.albums" />
    </AuthenticatedLayout>
</template>
