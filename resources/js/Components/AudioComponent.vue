<script setup>
import { onMounted, ref, } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from "@fortawesome/fontawesome-svg-core";
import { faPlay, faPause, faForwardFast, faBackwardFast, faVolumeUp, faVolumeMute } from '@fortawesome/free-solid-svg-icons';
import { eventBus } from '@/eventBus.js';
import "../../css/range.css";

library.add(faPlay, faPause, faForwardFast, faBackwardFast, faVolumeUp, faVolumeMute);

//local storage

const songs = usePage().props.auth.allSongs;

// const saveAllSong = localStorage.setItem("songs", JSON.stringify(songs));

// const allSongs = JSON.parse(localStorage.getItem("songs"));

//audio functions
//needed variable
let isPlaying = ref(false);
let songIndex = ref(localStorage.getItem('index') || 0);
let currentPlaylist = ref(JSON.parse(localStorage.getItem('currentPlaylist')) || []);
let volumeShow = ref(false);
let volume = ref(localStorage.getItem('volume'));
let isMuted = ref(false);
let progressBar = ref(0);
let progress = ref({});
let audio = ref(new Audio());
let currentTimeText = ref('00:00');
let cancelFunction = ref(false);

//audio control functions
const play = function () {
    audio.value.play();
    isPlaying.value = true;
}

const pause = function () {
    audio.value.pause();
    isPlaying.value = false;
}

const prev = function () {
    songIndex.value--;
    if (songIndex.value < 0) {
        songIndex.value = currentPlaylist.value.length - 1;
    }
    audio.value.oncanplaythrough = () => {
        audio.value.play();
    }
    localStorage.setItem('index', songIndex.value);
}

const next = function () {
    songIndex.value++;
    if (songIndex.value >= currentPlaylist.value.length) {
        songIndex.value = 0;
    }
    audio.value.oncanplaythrough = () => {
        audio.value.play();
    }
    localStorage.setItem('index', songIndex.value);
}

const onPlay = function () {
    isPlaying.value = true;
}

//volume functions
const adjustVolume = function () {
    audio.value.volume = volume.value / 100;
    if (volume.value == 0) {
        isMuted.value = true;
    } else {
        isMuted.value = false;
    }
}

const mute = function () {
    if (isMuted.value == false) {
        volume.value = 0;
        isMuted.value = true;
        audio.value.volume = 0;
    } else {
        isMuted.value = false;
        volume.value = localStorage.getItem('volume');
        audio.value.volume = volume.value / 100;
    }
}

const volumeZero = function () {
    if (volume.value == 0) {
        isMuted.value = true;
        audio.value.volume = 0;
    } else {
        localStorage.setItem('volume', volume.value);
    }
}

//seek functions
const updateProgress = function (time) {
    if (cancelFunction.value == false) {
        progressBar.value.value = time;
        let secs = `${parseInt(`${time % 60}`, 10)}`.padStart(2, '0');
        let mins = parseInt(`${(time / 60) % 60}`, 10);
        currentTimeText.value.innerHTML = `${mins}:${secs}`;
    }
}

const seek = function () {
    pause();
    cancelFunction.value = true;
    audio.value.currentTime = progressBar.value.value;
    setTimeout(() => {
        cancelFunction.value = false
    }, 10)
}

//eventBus
eventBus.on('playSong', (index) => {
    songIndex.value = index;
    audio.value.src = currentPlaylist.value[songIndex.value].song_path;
    isPlaying.value = true;
    audio.value.oncanplaythrough = () => {
        audio.value.play();
    }
})

onMounted(() => {
    progressBar.value.value = 0;
})

</script>


<template>
    <slot></slot>
    <div @playSong="onPlay()"
        class="absolute bottom-0 left-0 sticky bg-red-400 text-center max-w-7xl mx-96 sm:px-6 lg:px-8">
        <div>
            <span><span ref="currentTimeText">0:00</span> / {{ currentPlaylist[songIndex].length }}</span>
            <input type="range" name="progress" ref="progressBar" :max="audio.duration" @input="seek()" @change="play()">
        </div>
        <marquee id="songName" width="500px" scrollamount="1" direction="left">{{ currentPlaylist[songIndex].name }}
        </marquee>
        <audio :src="currentPlaylist[songIndex].song_path" ref="audio" @timeupdate="updateProgress(audio.currentTime)"
            @ended="next()"></audio>
        <font-awesome-icon icon="fa-solid fa-backward-fast" class="cursor-pointer" @click="prev()" />
        <font-awesome-icon :icon="isPlaying ? 'fa-pause' : 'fa-play'" class="ml-5 cursor-pointer"
            @click="isPlaying ? pause() : play()" />
        <font-awesome-icon icon="fa-solid fa-forward-fast" class="ml-5 cursor-pointer" @click="next()" />
        <span>
            <label for="volume" @click="mute()" @mouseover="volumeShow = true"
                @mouseleave="volumeShow = false"><font-awesome-icon
                    :icon="isMuted ? 'fa-solid fa-volume-mute' : 'fa-solid fa-volume-up'"
                    class="ml-5 cursor-pointer" /></label>
            <input @change="volumeZero()" @input="adjustVolume()" @mouseover="volumeShow = true"
                @mouseleave="volumeShow = false" v-show="volumeShow" type="range" id="volume" v-model="volume" min="0"
                max="100" class="cursor-pointer" step="1" style="margin-left: 10px ;width: 50px; height: 5px">
        </span>
    </div>
</template>

