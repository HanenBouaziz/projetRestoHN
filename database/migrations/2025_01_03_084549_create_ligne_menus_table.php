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
        Schema::create('ligne_menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menuID');
            $table->foreign('menuID') ->references('id') ->on('menus') ->onDelete('restrict');
            $table->unsignedBigInteger('articleID');
            $table->foreign('articleID') ->references('id') ->on('articles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ligne_menus');
    }
};
