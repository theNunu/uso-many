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
        Schema::create('item_catalog', function (Blueprint $table) {
            $table->id('item_catalog_id');

            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('catalog_id');

            $table->foreign('item_id')
                ->references('item_id')->on('items')
                ->cascadeOnDelete();

            $table->foreign('catalog_id')
                ->references('catalog_id')->on('catalogs')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_catalog');
    }
};
