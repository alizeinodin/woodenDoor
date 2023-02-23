<?php

namespace Tests\Feature;

use App\Http\Controllers\v1\UploadController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UploadTest extends TestCase
{
    use WithFaker;

    public function test_upload_image()
    {
        $file = UploadedFile::fake()->image('test.jpg');

        $uploader = new UploadController();
        $path = $uploader->storeImage($file);

        $this->assertFileExists($path);
    }
}
