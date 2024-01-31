<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DropZone from '@/Components/DropZone.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from "@fortawesome/fontawesome-svg-core";
import { faFileArrowDown } from '@fortawesome/free-solid-svg-icons';
import FilePreview from '@/components/FilePreview.vue';
import useFileList from '@/compositions/list-file.js';
import createUploader from '@/compositions/file-uploader.js';

const { files, addFiles, removeFile } = useFileList()

function onInputChange(e) {
    addFiles(e.target.files)
    e.target.value = null // reset so that selecting the same file again will still cause it to fire this change
}

library.add(faFileArrowDown);

const uploadSong = function () {
    router.post('/songs', {

    })
}
const { uploadFiles } = createUploader('YOUR URL HERE')
</script>
<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Upload New Songs</h2>
        </template>
        <div class="pt-8 max-w-6xl mx-auto">
            <DropZone class="drop-area" @files-dropped="addFiles" #default="{ dropZoneActive }">
                <div class="text-gray text-center z-10">
                    <label for="file-input" class="btn text-sky-500 underline decoration-sky-500" style="cursor:pointer">
                        <span v-if="dropZoneActive">
                            <div style="margin-bottom: 10px">
                                <font-awesome-icon class="fa-2xl" icon="fa-solid fa-file-arrow-down" />
                            </div>
                            <div>
                                Drop here to upload
                            </div>
                        </span>
                        <span v-else>
                            <div style="margin-bottom: 10px">
                                <font-awesome-icon class="fa-2xl" icon="fa-solid fa-file-arrow-down" />
                            </div>
                            <div>
                                Drag file here to upload
                            </div>
                            <div>
                                or click here
                            </div>
                        </span>
                    </label>
                    <input type="file" multiple accept=".mp3, .mp4, .m4a" id="file-input" style="display: none;" @change="onInputChange" >

                </div>
                <ul class="image-list" v-show="files.length">
                    <FilePreview v-for="file of files" :key="file.id" :file="file" tag="li" @remove="removeFile" />
                </ul>
            </DropZone>
            <PrimaryButton class="float-end mt-5 mr-0" style="margin-right: 0px !important ;" @click="uploadSong">Upload
            </PrimaryButton>
        </div>
    </AuthenticatedLayout>
</template>
