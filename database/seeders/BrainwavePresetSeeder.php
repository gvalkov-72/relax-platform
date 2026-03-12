<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BrainwavePreset;

class BrainwavePresetSeeder extends Seeder
{
    public function run(): void
    {

        BrainwavePreset::query()->delete();

        BrainwavePreset::insert([

            [
                'name' => 'Deep Sleep',
                'mode' => 'generator',
                'frequency' => 3,
                'duration' => 1800,
                'type' => 'delta',
                'audio_file' => null
            ],

            [
                'name' => 'Meditation',
                'mode' => 'generator',
                'frequency' => 6,
                'duration' => 1800,
                'type' => 'theta',
                'audio_file' => null
            ],

            [
                'name' => 'Relax',
                'mode' => 'generator',
                'frequency' => 10,
                'duration' => 1800,
                'type' => 'alpha',
                'audio_file' => null
            ],

            [
                'name' => 'Focus',
                'mode' => 'generator',
                'frequency' => 18,
                'duration' => 1800,
                'type' => 'beta',
                'audio_file' => null
            ],

            [
                'name' => 'Deep Sleep Audio',
                'mode' => 'audio',
                'frequency' => null,
                'duration' => 1800,
                'type' => 'delta',
                'audio_file' => 'audio/brainwaves/deep-sleep.mp3'
            ]

        ]);

    }
}