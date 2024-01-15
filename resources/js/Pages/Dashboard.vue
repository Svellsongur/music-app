<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import AllSongsLayout from '@/Layouts/AllSongsLayout.vue';

// import NavLink from '@/Components/NavLink.vue';
// import MusicTabPane from '@/Components/MusicTabPane.vue';
const data = usePage().props.data;


</script>

<template>
    <Head title="Music App" />

    <AuthenticatedLayout>
        <AllSongsLayout v-if="data.songs" :songs="data.songs" />

    </AuthenticatedLayout>
</template>
