<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('categories')->upsert([
            ['name' => 'Tourist Spots', 'slug' => 'tourist-spots', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Festivals',     'slug' => 'festivals',     'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Food Places',   'slug' => 'food-places',   'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Parks',         'slug' => 'parks',         'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Shopping',      'slug' => 'shopping',      'created_at' => $now, 'updated_at' => $now],
        ], ['slug'], ['name', 'updated_at']);
    }
}