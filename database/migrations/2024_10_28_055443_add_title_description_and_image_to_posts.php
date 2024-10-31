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
        Schema::table('posts', function (Blueprint $table) {
            $table->string("title")->after("id");
            $table->text("description")->after("title");
            $table->string("image")->after("description"); // 'url' o'rniga 'string' ishlatish
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn("title");
            $table->dropColumn("description");
            $table->dropColumn("image");
        });
    }
};
