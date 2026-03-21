<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('content_shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('permission')->default('edit'); // 'edit' или 'view' (за момента само edit)
            $table->timestamps();

            $table->unique(['content_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('content_shares');
    }
};