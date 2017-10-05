<?php

use Illuminate\Database\Seeder;
use App\Photo;

class PhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Photo::create(['file' => '1_headPhotoEX.jpg']);
        Photo::create(['file' => '2_headPhotoVII.jpg']);
    }
}
