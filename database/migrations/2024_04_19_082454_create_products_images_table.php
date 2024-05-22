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
        Schema::create('products_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id'); 
            $table->string('image_path');
            $table->timestamps();

            // Explicitly name the foreign key constraint
            $table->foreign('product_id', 'products_images_product_id_foreign')
                  ->references('id')->on('products')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products_images', function (Blueprint $table) {
            // Drop the foreign key constraint using the exact name
            $table->dropForeign('products_images_product_id_foreign');
        });
        Schema::dropIfExists('products_images');
    }
};
