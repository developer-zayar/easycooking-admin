<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Support\Facades\URL;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function saveImage($image, $path = "public")
    {
        if (!$image) {
            return null;
        }

        $fileName = time() . '.png'; //. $image->getClientOriginalExtension();

        // $img = Image::make($image->getRealPath());
        // $img->resize(120, 120, function ($constraint) {
        //     $constraint->aspectRatio();
        // });

        // $img->stream();

        Storage::disk($path)->put(
            $fileName,
            File::get($image)
        ); //File::get($image)

        return URL::to('/') . '/storage' . '/' . $path . '/' . $fileName;
    }

    public function uploadFile($file)
    {
        if (!$file) {
            return null;
        }

        $fileName = time() . $file->getClientOriginalExtension();

        // $img = Image::make($image->getRealPath());
        // $img->resize(120, 120, function ($constraint) {
        //     $constraint->aspectRatio();
        // });

        // $img->stream();

        Storage::disk('google')->put(
            $fileName,
            File::get($file)
        ); //File::get($image)

        return $fileName;
    }
}
