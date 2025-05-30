<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // who placed it
            $table->foreignId('customer_id')
                  ->constrained('customers')
                  ->onDelete('cascade');
            // what they ordered
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->enum('status', ['pending','processing','completed','cancelled'])
                  ->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
