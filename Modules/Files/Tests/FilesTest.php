<?php

namespace Modules\Files\Tests;

use Tests\TestCase;
use Plank\Mediable\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FilesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function can_upload_new_file()
    {
        $this->withoutExceptionHandling();
        Storage::fake('local');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $res = $this->json('post','api/files/upload',[
            'file' => $file
        ])
        ->assertRequestIsSuccessful()
        ->assertJsonStructure(['data' => ['id'] ]);

        $fileResult = json_decode($res->getContent());

        $file = Media::find($fileResult->data->id);

        Storage::disk('local')->assertExists($file->getDiskPath());
    }

    /** @test */
    public function can_not_upload_because_of_not_allowed_file()
    {

        Storage::fake('local');
        $file = UploadedFile::fake()->image('avatar.mp4');

        $this->json('post','api/files/upload',[
            'file' => $file
        ])
        ->assertStatus(400)
        ->assertJson(['meta' => generate_meta('failure', 'File type not supported')]);

    }
}
