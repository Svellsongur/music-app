<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';

var showAble = ref(false);
function onDrop(e) {
    e.preventDefault();
    showAble = true;
}

function onEnter(e) {
    e.preventDefault();
    // alert('abc');
    showAble.value = true;
}

function onDrag(e) {
    e.preventDefault();
    showAble = true;
}
</script>
<template>
    <AuthenticatedLayout>
        <div @drop.prevent="onDrop" @dragover.prevent="onDrag" @dragenter.prevent="onEnter"
            class="w-52 border-2 border-dashed text-g">
            Drop here
        </div>
        <div v-show="showAble">sakdj</div>
    </AuthenticatedLayout>
</template>
