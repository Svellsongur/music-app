<script setup>
import { onMounted, ref, } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from "@fortawesome/fontawesome-svg-core";
import { faPlay, faPause, faForwardFast, faBackwardFast, faVolumeUp, faVolumeMute, faRepeat, faShuffle } from '@fortawesome/free-solid-svg-icons';
import { eventBus } from '@/eventBus.js';
import "../../css/range.css";

library.add(faPlay, faPause, faForwardFast, faBackwardFast, faVolumeUp, faVolumeMute, faRepeat, faShuffle);

//local storage

const songs = usePage().props.auth.allSongs;

//audio functions
//needed variable
let isPlaying = ref(false);
let songIndex = ref(localStorage.getItem('index') || 0);
let currentPlaylist = ref(JSON.parse(localStorage.getItem('currentPlaylist')) || []);

//debug lines
// let currentPlaylist = ref(songs);
// localStorage.setItem('currentPlaylist', JSON.stringify(currentPlaylist.value));

let volumeShow = ref(false);
let volume = ref(localStorage.getItem('volume'));
let isMuted = ref(false);
let progressBar = ref(0);
let progress = ref({});
let audio = ref(new Audio());
let currentTimeText = ref('00:00');
let display = ref(false);
let isShuffled = ref(false);
let songShuffled = ref(false);
let isLooped = ref(false);
let disableUpdateTimer = ref(false);

//audio control functions
const play = function () {
    display.value = true;
    audio.value.play();
    isPlaying.value = true;
    if (currentPlaylist.value.length == 1) {
        audio.value.setAttribute("loop", true)
    } else {
        audio.value.removeAttribute("loop")
    }
}

const pause = function () {
    audio.value.pause();
    isPlaying.value = false;
}

const prev = function () {
    isPlaying.value = false;
    currentPlaylist.value = JSON.parse(localStorage.getItem('currentPlaylist'));
    let currentSong = currentPlaylist.value[songIndex.value];
    if (isShuffled.value == true && songShuffled.value == false) {
        shuffle(currentPlaylist.value);
        songShuffled.value = true;
    } if (isShuffled.value == false && songShuffled.value == true) {
        currentPlaylist.value.sort();
        songShuffled.value = false;
    }
    songIndex.value--;
    if (songIndex.value < 0) {
        songIndex.value = currentPlaylist.value.length - 1;
    }
    if (currentSong.id == currentPlaylist.value[songIndex.value].id) {
        prev();
    }
    audio.value.oncanplaythrough = () => {
        audio.value.play();
    }
    localStorage.setItem('index', songIndex.value);
    isPlaying.value = true;
}

const next = function () {
    isPlaying.value = false;
    currentPlaylist.value = JSON.parse(localStorage.getItem('currentPlaylist'));
    let currentSong = currentPlaylist.value[songIndex.value];
    if (isShuffled.value == true && songShuffled.value == false) {
        shuffle(currentPlaylist.value);
        songShuffled.value = true;
    }
    if (isShuffled.value == false && songShuffled.value == true) {
        currentPlaylist.value.sort();
        songShuffled.value = false;
        // console.log(currentPlaylist.value);
    }
    songIndex.value++;
    if (songIndex.value >= currentPlaylist.value.length) {
        songIndex.value = 0;
    }
    if (currentSong.id == currentPlaylist.value[songIndex.value].id) {
        next();
    }
    audio.value.oncanplaythrough = () => {
        audio.value.play();
    }
    localStorage.setItem('index', songIndex.value);
    isPlaying.value = true;
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
    // if (disableTimeupdate) return;
    progressBar.value.value = time;
    let secs = `${parseInt(`${time % 60}`, 10)}`.padStart(2, '0');
    let mins = parseInt(`${(time / 60) % 60}`, 10);
    currentTimeText.value.innerHTML = `${mins}:${secs}`;
}

// const stopFunction = debounce(function () {
//     disableUpdateTimer.value = true;
// }, 1000);

const stopTimeUpdate = function () {
    pause();
    // stopFunction();
}

const seek = function () {
    audio.value.currentTime = progressBar.value.value;
    play()
}

const close = function () {
    display.value = false;
    pause();
}

//shuffle
//shuffle array func
const shuffle = function (array) {
    let currentIndex = array.length, randomIndex;

    while (currentIndex > 0) {
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex--;
        [array[currentIndex], array[randomIndex]] = [array[randomIndex], array[currentIndex]];
    }

    return array;
}

//shuffle music
const shuffleMusic = function () {
    if (isShuffled.value == false) {
        isShuffled.value = true;
        songShuffled.value = false;
        console.log('isShuffled:' + isShuffled.value);
        console.log('songShuffled:' + songShuffled.value);
    } else {
        isShuffled.value = false;
        songShuffled.value = true;
        console.log('isShuffled:' + isShuffled.value);
        console.log('songShuffled:' + songShuffled.value);
    }
}

//loop
const loopMusic = function () {
    if (isLooped.value == false) {
        audio.value.setAttribute("loop", true);
        isLooped.value = true;
    } else {
        audio.value.removeAttribute("loop");
        isLooped.value = false;
    }
}

//eventBus
eventBus.on('playSong', (index) => {
    currentPlaylist.value = JSON.parse(localStorage.getItem('currentPlaylist'));
    songIndex.value = index;
    audio.value.src = currentPlaylist.value[songIndex.value].song_path;
    isPlaying.value = true;
    display.value = true;
    audio.value.oncanplaythrough = () => {
        audio.value.play();
        progressBar.value.setAttribute("max", audio.value.duration);
    }

})

onMounted(() => {
    progressBar.value.value = 0;
    audio.value.volume = volume.value / 100;
})

</script>


<template>
    <slot></slot>
    <div v-show="display" @playSong="onPlay()"
        class="absolute bottom-0 left-0 sticky bg-red-400 text-center max-w-7xl w-80 mx-auto">
        <marquee id="songName" width="80%" scrollamount="1" direction="left">{{ currentPlaylist.length > 0 ?
            currentPlaylist[songIndex].name : '' }}</marquee>
        <audio :src="currentPlaylist.length > 0 ? currentPlaylist[songIndex].song_path : ''" ref="audio"
            @timeupdate="updateProgress(audio.currentTime)" @ended="next()" hidden></audio>
        <div class="inline-block w-full mt-0 flex items-center">
            <div class="flex justify-between ml-12 items-center">
                <span ref="currentTimeText" class="mr-2">0:00</span>
                <input type="range" name="progress" ref="progressBar" :max="audio.duration" @input="stopTimeUpdate()"
                    @change="seek()" @click="stopTimeUpdate()">
                <span class="ml-2">{{ currentPlaylist.length > 0 ? currentPlaylist[songIndex].length : '' }}</span>
            </div>
            <span class="ml-10 float-right cursor-pointer" @click="close()">X</span>
        </div>
        <div class="inline-block" @mouseleave="volumeShow = false">
            <font-awesome-icon :style="{ color: isShuffled ? 'red' : '' }" icon="fa-solid fa-shuffle" class="cursor-pointer"
                @click="shuffleMusic()" />
            <font-awesome-icon icon="fa-solid fa-repeat" class="ml-5 cursor-pointer" @click="loopMusic()" />
            <font-awesome-icon icon="fa-solid fa-backward-fast" class="ml-5 cursor-pointer" @click="prev()" />
            <font-awesome-icon :icon="isPlaying ? 'fa-pause' : 'fa-play'" class="ml-5 cursor-pointer"
                @click="isPlaying ? pause() : play()" />
            <font-awesome-icon icon="fa-solid fa-forward-fast" class="ml-5 cursor-pointer" @click="next()" />
            <span>
                <label for="volume" @click="mute()" @mouseover="volumeShow = true"><font-awesome-icon
                        :icon="isMuted ? 'fa-solid fa-volume-mute' : 'fa-solid fa-volume-up'"
                        class="ml-5 cursor-pointer" /></label>
                <input @change="volumeZero()" @input="adjustVolume()" @mouseover="volumeShow = true" v-show="volumeShow"
                    type="range" id="volume" v-model="volume" min="0" max="100" class="cursor-pointer" step="1"
                    style="margin-left: 10px ;width: 50px; height: 5px">
            </span>
        </div>
    </div>
</template>

