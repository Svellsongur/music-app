import { ref } from "vue";

export default function () {
    const files = ref([]);

    var allowedExtensions = /(\.mp3|\.mp4|\.m4a)$/i;

    function addFiles(newFiles) {
        for (const file of newFiles) {
            if (!allowedExtensions.exec(file.name)) {
                alert("Audio file only!");
                files.error = true;
            } else {
                let newUploadableFiles = [...newFiles]
                    .map((file) => new UploadableFile(file))
                    .filter((file) => !fileExists(file.id));
                files.value = files.value.concat(newUploadableFiles);
            }
        }
    }

    function fileExists(otherId) {
        return files.value.some(({ id }) => id === otherId);
    }

    return { files, addFiles };
}

class UploadableFile {
    constructor(file) {
        this.file = file;
        this.id = `${file.name}-${file.size}-${file.lastModified}-${file.type}`;
        this.url = URL.createObjectURL(file);
        this.status = null;
        // console.log(file);
    }
}
