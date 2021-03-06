<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageControllerTest extends TestCase
{

    /**
     * @test
     */
    public function 画像作成APIをたたくとimgのurlがかえってくる()
    {
        Storage::fake('local');

        $file = UploadedFile::fake()->image('something.png');

        $response = $this->json('POST', '/api/images', [
            'file'    => $file
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['img']);

        Storage::disk('local')->assertExists("public/uploaded/{$file->hashName()}");
        Storage::disk('local')->assertMissing("public/uploaded/something.png");
    }

    /**
     * @test
     */
    public function ３MBより大きい画像をなげると400()
    {
        Storage::fake('local');

        $file = UploadedFile::fake()->image('something.png')->size(3001);

        $response = $this->json('POST', '/api/images', [
            'file'    => $file
        ]);

        $response->assertStatus(400);

        Storage::disk('local')->assertMissing("public/uploaded/something.png");
    }
}
