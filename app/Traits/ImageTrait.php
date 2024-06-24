<?php

namespace App\Traits;


Trait  ImageTrait
{
    // ---------------- [ Save image ] ----------------
    function saveImage($photo,$folder){
        //save photo in folder
        $file_extension = $photo -> getClientOriginalExtension();
        $file_name =  time().rand().'.'.$file_extension;
        $file_path=public_path(). '/images/'.$folder;
        $photo -> move($file_path,$file_name);
        return 'images/'.$folder.'/'. $file_name;
    }



    // ---------------- [ Delete image ] ----------------
    public function deleteImage($photo) {

        if($photo)
            unlink($photo);
    }



}
