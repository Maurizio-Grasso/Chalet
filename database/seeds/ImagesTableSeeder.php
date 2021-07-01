<?php

use Illuminate\Database\Seeder;
use App\Image;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Images= config('apartment_images');

        foreach ($Images as $Image ) {
            $newImage = new Image();

            $newImage->apartment_id = $Image['apartment_id'];
            $newImage->img_path = $Image['img_path'];
            $newImage->img_description = $Image['img_description'];
            $newImage->is_cover = $Image['is_cover'];
            $newImage->save();
        }
    }
}
