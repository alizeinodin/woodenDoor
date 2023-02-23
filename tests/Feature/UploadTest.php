<?php

namespace Tests\Feature;

use App\Http\Controllers\v1\UploadController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadTest extends TestCase
{
    use WithFaker;

    public function test_upload_image()
    {
        Storage::fake('images');

        $file = UploadedFile::fake()->image('test.jpg');

        $uploader = new UploadController();
        $path = $uploader->storeImage($file);

        $this->assertFileExists("storage/app/$path");
    }
}
