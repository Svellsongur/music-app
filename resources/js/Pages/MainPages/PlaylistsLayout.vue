
<script setup>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from "@fortawesome/fontawesome-svg-core";
import { faChevronRight, faPlus } from '@fortawesome/free-solid-svg-icons';

library.add(faChevronRight, faPlus);

defineProps({
    playlists: {
        type: Array
    }
})
</script>


<template>
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Playlists</h2>
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
        <div class="pt-8 mx-10">
            <div class="max-w-xl mx-0 pr-0 sm:px-6 lg:px-8 ">
                <button class="w-full py-2 bg-white overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 text-center">
                    <div class="p-3 text-gray-900">
                        <div class="text-xl overflow-hidden">Add new playlist +</div>
                    </div>
                </button>
            </div>
        </div>
    </div>
</template>
