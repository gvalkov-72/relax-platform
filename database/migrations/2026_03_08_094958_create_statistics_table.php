<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statistics', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('session_type');

            $table->integer('duration');

            $table->float('frequency')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistics');
    }
};