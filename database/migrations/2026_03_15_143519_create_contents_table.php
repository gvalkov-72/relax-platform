<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'idea', 'document', 'message' и др.
            $table->string('title');
            $table->string('excerpt')->nullable(); // кратко описание/тема
            $table->longText('body'); // основно съдържание (rich text)
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamp('published_at')->nullable(); // дата на публикуване (ако е различна от created_at)
            $table->timestamps();

            $table->index('type');
            $table->index('created_by');
        });
    }

    public function down()
    {
        Schema::dropIfExists('contents');
    }
};