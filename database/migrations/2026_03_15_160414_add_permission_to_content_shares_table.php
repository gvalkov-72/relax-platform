<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('content_shares', function (Blueprint $table) {
            if (!Schema::hasColumn('content_shares', 'permission')) {
                $table->string('permission')->default('edit')->after('user_id');
            }
        });
    }

    public function down()
    {
        Schema::table('content_shares', function (Blueprint $table) {
            $table->dropColumn('permission');
        });
    }
};