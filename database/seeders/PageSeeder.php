<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pages')->delete();

        DB::table('pages')->insert([
            [
                'slug' => 'home',
                'title' => 'Home',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'meditation',
                'title' => 'Meditation',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'sleep',
                'title' => 'Sleep',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}