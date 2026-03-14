<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->longText('content');
            $table->json('embedding')->nullable(); // векторно представяне
            $table->json('metadata')->nullable();  // допълнителни данни
            $table->string('source_type');         // 'page', 'section'
            $table->unsignedBigInteger('source_id');
            $table->timestamps();

            $table->index(['source_type', 'source_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
};