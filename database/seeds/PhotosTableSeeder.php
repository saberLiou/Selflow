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
        Photo::create(['file' => 'headPhotoEX.jpg']);
        Photo::create(['file' => 'headPhotoVII.jpg']);
    }
}
