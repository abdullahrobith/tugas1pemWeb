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
        Schema::create('order_details', function (Blueprint $table) {
        $table->id(); 
        $table->unsignedBigInteger('order_id'); 
        $table->unsignedBigInteger('product_id'); 
        $table->unsignedInteger('quantity')->default(1); 
        $table->decimal('unit_price', 10, 2); 
        $table->decimal('subtotal', 10, 2); 
        $table->timestamp('created_at')->nullable(); 
        $table->timestamp('updated_at')->nullable(); 
        // FOREIGN KEY CONSTRAINTS
        $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        $table->foreign('product_id')->references('id')->on('product_categories')->onDelete('cascade');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
