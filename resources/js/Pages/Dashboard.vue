<script setup>
import AudioComponent from '@/Components/AudioComponent.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import AllSongsLayout from '@/Pages/MainPages/AllSongsLayout.vue';
import PlaylistsLayout from '@/Pages/MainPages/PlaylistsLayout.vue';
import ArtistsLayout from '@/Pages/MainPages/ArtistsLayout.vue';
import AlbumsLayout from '@/Pages/MainPages/AlbumsLayout.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from "@fortawesome/fontawesome-svg-core";
import { faPlay, faPause, faForwardFast, faBackwardFast } from '@fortawesome/free-solid-svg-icons';


defineOptions({
    layout: AudioComponent
})

library.add(faPlay, faPause, faForwardFast, faBackwardFast);

//back end data
const data = usePage().props.data;
</script>

<template>
    <Head title="Music App" />

    <AuthenticatedLayout>
        <AllSongsLayout v-if="data.songs" :totalSongs="data.totalSongs" :songs="data.songs" />
        <PlaylistsLayout v-if="data.playlists" :playlists="data.playlists" />
        <ArtistsLayout v-if="data.artists" :artists="data.artists" />
        <AlbumsLayout v-if="data.albums" :albums="data.albums" />
    </AuthenticatedLayout>
</template>

