<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        $this->call([
            RolesSeeder::class,
            //LanguageSeeder::class,
            //PageSeeder::class,
            //AudioSeeder::class,
            //BrainwavePresetSeeder::class,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}