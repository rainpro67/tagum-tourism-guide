<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlaceSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $cat = DB::table('categories')->pluck('id', 'slug');

        DB::table('places')->upsert([
            [
                'name' => 'Tagum City Hall Plaza',
                'slug' => 'city-hall-plaza',
                'category_id' => $cat['tourist-spots'],
                'description' => 'Central plaza in the heart of Tagum City.',
                'address' => 'Tagum City, Davao del Norte',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Tagum Public Park',
                'slug' => 'tagum-public-park',
                'category_id' => $cat['parks'],
                'description' => 'Green space for families and events.',
                'address' => 'Tagum City, Davao del Norte',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Local Food Street',
                'slug' => 'local-food-street',
                'category_id' => $cat['food-places'],
                'description' => 'Local street food and restaurants.',
                'address' => 'Tagum City, Davao del Norte',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Tagum City Mall',
                'slug' => 'tagum-city-mall',
                'category_id' => $cat['shopping'],
                'description' => 'Shopping and dining center.',
                'address' => 'Tagum City, Davao del Norte',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Festival Grounds',
                'slug' => 'festival-grounds',
                'category_id' => $cat['festivals'],
                'description' => 'Main venue for city festivals.',
                'address' => 'Tagum City, Davao del Norte',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ], ['slug'], ['name', 'category_id', 'description', 'address', 'updated_at']);
    }
}