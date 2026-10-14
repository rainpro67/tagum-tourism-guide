<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $place = DB::table('places')->pluck('id', 'slug');

        DB::table('events')->upsert([
            [
                'title' => 'Tagum Festival Parade',
                'slug' => 'tagum-festival-parade',
                'place_id' => $place['festival-grounds'],
                'description' => 'Annual street parade and celebration.',
                'start_date' => '2026-11-15 08:00:00',
                'end_date' => '2026-11-15 17:00:00',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Food Fair',
                'slug' => 'food-fair',
                'place_id' => $place['local-food-street'],
                'description' => 'Local food and delicacies.',
                'start_date' => '2026-11-20 10:00:00',
                'end_date' => '2026-11-20 21:00:00',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Park Fun Run',
                'slug' => 'park-fun-run',
                'place_id' => $place['tagum-public-park'],
                'description' => 'Community fun run for all ages.',
                'start_date' => '2026-12-01 06:00:00',
                'end_date' => '2026-12-01 10:00:00',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ], ['slug'], ['title', 'place_id', 'description', 'start_date', 'end_date', 'updated_at']);
    }
}