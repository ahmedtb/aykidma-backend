<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Image;
use App\Models\Order;
use App\Rules\Base64Rule;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;

class FunctionalitiesLab extends TestCase
{
    use RefreshDatabase;

    public function test_base64_images_can_be_validated_saved_as_files_and_deleted()
    {
        $order = Order::factory()->create();
        $base64_image = ($order->fields[4]['value']);
        $base64Rule = new Base64Rule(1000);
        $isValidbasse64 = $base64Rule->passes('value', $base64_image);
        $this->assertTrue($isValidbasse64);
        // if (!$isValidbasse64)
        //     dd('string is not a valid base64 file');

        $path = storeBase64PngFile($base64_image);

        $filedDeleted = deletePublicFile($path);

        $this->assertTrue($filedDeleted);
    }

    public function test_image_create_with_base64_string_and_when_deleted_it_delete_drive_file()
    {
        $this->withoutExceptionHandling();
        $order = Order::factory()->create();
        $base64_image = ($order->fields[4]['value']);
        $image = Image::createWithBase64($base64_image);
        $image->delete();
        $this->assertEquals(Image::all()->count(), 0);
    }
}
