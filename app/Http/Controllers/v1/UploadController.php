<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;

class UploadController extends Controller
{
    public const IMAGE_DIR = 'images';

    public function storeImage(UploadedFile $file): bool|string
    {
        $path = $file->store(self::IMAGE_DIR);

        if (!(bool)$path) {

            $response = [
                'message' => 'Error in upload image'
            ];

            return response($response, 422);
        }

        return $path;
    }
}
