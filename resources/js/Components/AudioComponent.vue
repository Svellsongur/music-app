<script setup>
import { onMounted, ref, watchEffect, inject } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from "@fortawesome/fontawesome-svg-core";
import { faPlay, faPause, faForwardFast, faBackwardFast } from '@fortawesome/free-solid-svg-icons';

library.add(faPlay, faPause, faForwardFast, faBackwardFast);

//local storage

const songs = usePage().props.auth.allSongs;

const saveAllSong = localStorage.setItem("songs", JSON.stringify(songs));

const allSongs = JSON.parse(localStorage.getItem("songs"));

//audio functions
let isPlaying = ref(false);

let currentSong = ref(JSON.parse(localStorage.getItem('currentSong')));
let currentPlaylist = ref(JSON.parse(localStorage.getItem('currentPlaylist')) || []);

//audio control functions
const play = function () {
    audio.play();
    isPlaying.value = true;
}

const pause = function () {
    audio.pause();
    isPlaying.value = false;
}

const prev = function () {
    console.log("prev");
}

const next = function () {
    console.log("next");
}

const onPlay = function () {
    console.log(isPlaying.value);
    isPlaying.value = true;
}

onMounted(() => {
    let audio = document.querySelector('#audio');

})

</script>


<template>
    <slot></slot>
    <div @playSong="onPlay()" class="absolute bottom-0 left-0 sticky bg-red-400 text-center max-w-7xl mx-96 sm:px-6 lg:px-8">
        <marquee id="songName" width="500px" scrollamount="1" direction="left">{{ currentSong.name }}</marquee>
        <audio :src="currentSong.song_path" id="audio"></audio>
        <font-awesome-icon icon="fa-solid fa-backward-fast" class="cursor-pointer" @click="prev()" />
        <font-awesome-icon :icon="isPlaying ? 'fa-pause' : 'fa-play'" class="ml-5 cursor-pointer"
            @click="isPlaying ? pause() : play()" />
        <font-awesome-icon icon="fa-solid fa-forward-fast" class="ml-5 cursor-pointer" @click="next()" />
    </div>
</template>

