<template>
	<component :is="tag" class="file-preview">

		<!-- <audio :src="file.url" :alt="file.file.name" :title="file.file.name" /> -->
        <span class="filename">{{ file.file.name }}</span>
        <button @click="$emit('remove', file)" class="close-icon">&times;</button>
		<span class="status-indicator loading-indicator" v-show="file.status == 'loading'">In Progress</span>
		<span class="status-indicator success-indicator" v-show="file.status == true">Uploaded</span>
		<span class="status-indicator failure-indicator" v-show="file.status == false">Error</span>
	</component>
</template>

<script setup>
defineProps({
	file: { type: Object, required: true },
	tag: { type: String, default: 'li' },
})

defineEmits(['remove'])
</script>
