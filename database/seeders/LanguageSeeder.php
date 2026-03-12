<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('languages')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('languages')->insert([
            [
                'code' => 'bg',
                'name' => 'Bulgarian',
                'is_default' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'en',
                'name' => 'English',
                'is_default' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}