<script setup>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from "@fortawesome/fontawesome-svg-core";
import { faChevronRight, faPlus } from '@fortawesome/free-solid-svg-icons';
import { router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

library.add(faChevronRight, faPlus);

defineProps({
    albums: {
        type: Array
    }
})

const addSong = function () {
    router.get('/songs/add')
}
</script>


<template>
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-13">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight col-span-8">My Albums</h2>
                <div class="col-end-16 col-start-13">
                    <PrimaryButton @click="addSong()" style="margin-right: 0 !important;">Add Songs</PrimaryButton>
                </div>
            </div>
        </div>
    </header>
    <div class="grid grid-cols-2 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="pt-8 mx-10" v-for="album in albums">
            <div class="max-w-xl mx-0 pr-0 sm:px-6 lg:px-8 ">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50">
                    <button class="p-3 text-gray-900 text-left">
                        <div class="grid grid-cols-12">
                            <div class="col-span-11 items-center py-2">
                                <div class="text-xl overflow-hidden">{{ album.name }}</div>
                                <div class="text-sm">{{ album.artist }}</div>
                            </div>
                            <div class="inline-flex w-full gap-x-1.5 px-7 py-6 text-sm font-semibold text-gray-900">
                                <font-awesome-icon icon="chevron-right" />
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
