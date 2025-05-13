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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('sku',50)->nullable();
            $table->decimal('price', 10, 2)->default(0); // price: min 0
            $table->integer('stock')->default(0);
            $table->unsignedBigInteger('product_category_id')->nullable(); // nullable FK
            $table->foreign('product_category_id')
                  ->references('id')
                  ->on('product_categories')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
            $table->string('image_url', 255)->nullable(); // image_url: optional
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
