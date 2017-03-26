<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Product::create([
           'name' => 'Acoustic',
           'slug' => 'A-cou-stic',
           'description' => 'aaaaaaaaaaaaaaaaaaaa',
           'price' => '50.99',
           'image' => 'acoustic.jpg'
        ]);

        App\Product::create([
           'name' => 'Electric',
           'slug' => 'E-lec-tric',
           'description' => 'bbbbbbbbbbbbbbbbbbbb',
           'price' => '60.99',
           'image' => 'electric.jpg'
        ]);

        App\Product::create([
           'name' => 'Headphones',
           'slug' => 'Head-phones',
           'description' => 'ccccccccccccccccccccc',
           'price' => '65.99',
           'image' => 'headphones.jpg'
        ]);

        App\Product::create([
           'name' => 'Ipadretina',
           'slug' => 'I-pad-retina',
           'description' => 'ddddddddddddddddddddddd',
           'price' => '40.99',
           'image' => 'ipad-retina.jpg'
        ]);

        App\Product::create([
           'name' => 'MacbookPro',
           'slug' => 'Mac-book-pro',
           'description' => 'eeeeeeeeeeeeeeeeeeeeeeee',
           'price' => '50.99',
           'image' => 'macbook-pro.jpg'
        ]);

        App\Product::create([
           'name' => 'Ps4',
           'slug' => 'Ps-4',
           'description' => 'fffffffffffffffffffffffff',
           'price' => '60.99',
           'image' => 'ps4.jpg'
        ]);

        App\Product::create([
           'name' => 'Speakers1',
           'slug' => 'Speakers-1',
           'description' => 'ggggggggggggggggggggggggggg',
           'price' => '80.99',
           'image' => 'speakers.jpg'
        ]);

        App\Product::create([
           'name' => 'Xboxone',
           'slug' => 'Xbox-one',
           'description' => 'hhhhhhhhhhhhhhhhhhhhhhhhhhhhh',
           'price' => '40.99',
           'image' => 'xbox-one.jpg'
        ]);
    }
}
