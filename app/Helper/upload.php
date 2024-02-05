<?php
    //upload file
    function uploadfile($nameFolder, $file){
        $fileName = $file->getClientOriginalName();
        return $file->storeAS($nameFolder, $fileName, 'public');
    }
