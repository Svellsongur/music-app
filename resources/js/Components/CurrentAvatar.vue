<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: {
        type: String,
        required: true,
    },
});

defineEmits(['update:modelValue']);

const fileInput = ref(null);

onMounted(() => {
    if (fileInput.value.hasAttribute('autofocus')) {
        fileInput.value.focus();
    }
});

defineExpose({
    focus: () => fileInput.value.focus(),
    handleFileChange: (event) => {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = () => {
            const dataUrl = reader.result;
            console.log(dataUrl);
            $emit('update:modelValue', dataUrl);
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    },
});
</script>


<template>
    <div>
      <input
        type="file"
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        @change="handleFileChange"
        ref="fileInput"
      />
    </div>
  </template>
