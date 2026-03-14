<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('section_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained()->cascadeOnDelete();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->json('data')->nullable(); // съдържа всички специфични за типа данни (например масив от членове на екипа)
            $table->timestamps();

            $table->unique(['section_id', 'language_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('section_translations');
    }
};