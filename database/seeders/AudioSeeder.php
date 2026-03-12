<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AudioFile;

class AudioSeeder extends Seeder
{
    public function run(): void
    {
        AudioFile::query()->delete();

        AudioFile::insert([

            [
                'title' => 'Rain',
                'type' => 'ambient',
                'file_path' => 'audio/rain.mp3',
                'duration' => 0,
                'is_active' => true
            ],

            [
                'title' => 'Ocean Waves',
                'type' => 'ambient',
                'file_path' => 'audio/ocean.mp3',
                'duration' => 0,
                'is_active' => true
            ],

            [
                'title' => 'Forest',
                'type' => 'ambient',
                'file_path' => 'audio/forest.mp3',
                'duration' => 0,
                'is_active' => true
            ],

            [
                'title' => 'Wind',
                'type' => 'ambient',
                'file_path' => 'audio/wind.mp3',
                'duration' => 0,
                'is_active' => true
            ]

        ]);
    }
}