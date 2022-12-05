<?php

namespace App\traits;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

trait ImageTrait
{

    public function saveImage($file, $folder, $name)
    {

        $file_ext = $file->getClientOriginalExtension();
        $file_name = null;
        if ($name == null) {
            $file_name =  time() . "." . 'jpg';
        } else {
            $file_name = $name . "." . 'jpg';
        }
        $path = "images/" . $folder;
        $image = Image::make($file);
        $image->resize(300, 200);
        if (!file_exists($path)) {
            File::makeDirectory($path, 0755, true, true);
        }
        $image->save($path . "/" . $file_name, 50, "jpg");
        return $path . "/" . $file_name;
    }

    public function deleteImage($filename)
    {


        File::delete($filename);
    }
}
