<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // row id

            $table->unsignedBigInteger('order_id'); // groups multiple products

            // ✅ link to users table
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // ✅ link to products table
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');

            $table->unsignedInteger('quantity');
            $table->decimal('price', 10, 2); // price per product

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};