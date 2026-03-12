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
        Schema::create('meditation_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('meditation_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('item_type');

            $table->unsignedBigInteger('item_id')->nullable();

            $table->integer('volume')->default(100);

            $table->integer('start_time')->default(0);

            $table->integer('duration')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meditation_items');
    }
};