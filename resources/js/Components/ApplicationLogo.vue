<script setup>
defineProps({
    modelValue: {
        type: String,
    },
})
</script>
<template>
    <img :src="modelValue" alt="Logo">
</template>
