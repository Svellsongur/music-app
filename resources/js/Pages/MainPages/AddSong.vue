<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DropZone from '@/Components/DropZone.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from "@fortawesome/fontawesome-svg-core";
import { faFileArrowDown, faCircleArrowLeft } from '@fortawesome/free-solid-svg-icons';
import FilePreview from '@/components/FilePreview.vue';
import useFileList from '@/compositions/list-file.js';
import AudioComponent from '@/Components/AudioComponent.vue';
import Swal from 'sweetalert2';

defineOptions({
    layout: AudioComponent
})

const { files, addFiles } = useFileList()

const form = useForm({
    files: ref(files),
})
let showIcon = ref(true);

function onInputChange(e) {
    addFiles(e.target.files)
    e.target.value = null // reset so that selecting the same file again will still cause it to fire this change
    form.files = files
    showIcon.value = false;
}

function dropFiles(e) {
    addFiles(e)
    form.files = files
    showIcon.value = false
}

function removeFile(file) {
    const index = files.value.indexOf(file);
    if (index > -1) { files.value.splice(index, 1) };
    form.files = files
}

// console.log(files.value);
// console.log(files);
// console.log(form.files);

library.add(faFileArrowDown, faCircleArrowLeft);

const uploadSong = function () {
    // if (form.files.value) {
    form.post('/songs/add', {
        onSuccess: (response) => {
            // console.log(response);
            if (response.props.error) {
                // Display error message
                Swal.fire({
                    title: 'Error!',
                    text: response.props.error,
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            } else {
                // Display success message
                Swal.fire({
                    title: 'Success!',
                    text: 'Songs uploaded successfully!',
                    icon: 'success',
                    confirmButtonText: 'Ok'
                });
                router.get('/songs/add');
            }
        }
    })
}

const back = function () {
    window.history.back();
}

</script>
<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Upload New Songs</h2>
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-3">
            <button @click="back()">
                <font-awesome-icon class="mx-auto mt-3" icon="fa-solid fa-circle-arrow-left" size="xl"
                    style="cursor:pointer" />
            </button>
        </div>
        <div class="pt-8 max-w-6xl mx-auto mb-10">
            <form @submit.prevent="uploadSong" enctype="multipart/form-data">
                <DropZone class="drop-area" @files-dropped="dropFiles" #default="{ dropZoneActive }">
                    <div class="text-gray text-center z-2">
                        <ul class="image-list" :ref="form.files" v-show="files.length">
                            <FilePreview v-for="file, index of files" :index="index" :key="file.id" :file="file" tag="li"
                                @remove="removeFile" />
                        </ul>
                        <label for="file-input" class="btn text-sky-500 underline decoration-sky-500"
                            style="cursor:pointer">
                            <span v-if="dropZoneActive">
                                <div style="margin-bottom: 10px">
                                    <font-awesome-icon class="fa-2xl" icon="fa-solid fa-file-arrow-down" />
                                </div>
                                <div>
                                    Drop here to upload
                                </div>
                            </span>
                            <span v-else>
                                <div style="margin-bottom: 10px" v-show="showIcon">
                                    <font-awesome-icon class="fa-2xl" icon="fa-solid fa-file-arrow-down" />
                                </div>
                                <div>
                                    Drag file here to upload or click here
                                </div>
                            </span>
                        </label>
                        <input type="file" multiple accept=".mp3, .mp4, .m4a" id="file-input" style="display: none;"
                            @change="onInputChange">

                    </div>
                </DropZone>
                <PrimaryButton class="float-end mt-5 mr-0" style="margin-right: 0px !important ;">Upload
                </PrimaryButton>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
