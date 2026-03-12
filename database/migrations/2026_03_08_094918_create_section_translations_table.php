<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('section_translations', function (Blueprint $table) {

            $table->id();

            $table->foreignId('section_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('language_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');
            $table->text('content')->nullable();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('section_translations');
    }
};