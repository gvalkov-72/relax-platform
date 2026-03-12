<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('brainwave_presets', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->float('base_frequency')->default(200);

            $table->float('beat_frequency');

            $table->integer('duration')->default(600);

            $table->boolean('is_active')->default(true);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brainwave_presets');
    }
};