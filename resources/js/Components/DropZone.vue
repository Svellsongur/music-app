<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const emit = defineEmits(['files-dropped'])

let active = ref(false)
let inActiveTimeout = null

// setActive and setInactive use timeouts, so that when you drag an item over a child element,
// the dragleave event that is fired won't cause a flicker. A few ms should be plenty of
// time to wait for the next dragenter event to clear the timeout and set it back to active.
function setActive() {
	active.value = true
	clearTimeout(inActiveTimeout)
}
function setInactive() {
	inActiveTimeout = setTimeout(() => {
		active.value = false
	}, 50000)
}

function onDrop(e) {
	setInactive()
	emit('files-dropped', [...e.dataTransfer.files])
}

function preventDefaults(e) {
	e.preventDefault()
}

const events = ['dragenter', 'dragover', 'dragleave', 'drop']

onMounted(() => {
	events.forEach((eventName) => {
		document.body.addEventListener(eventName, preventDefaults)
	})
})

onUnmounted(() => {
	events.forEach((eventName) => {
		document.body.removeEventListener(eventName, preventDefaults)
	})
})

</script>
<template>
    <div :data-active="active" @dragenter.prevent="setActive" @dragover.prevent="setActive" @dragleave.prevent="setInactive" @drop.prevent="onDrop" style="height: 300px!important;"
        class="mx-auto max-w-6xl border-2 border-dashed bg-white flex items-center grid justify-items-center">
        <slot :dropZoneActive = "active"></slot>
    </div>

</template>
