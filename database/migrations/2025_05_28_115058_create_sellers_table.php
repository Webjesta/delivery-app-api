<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            // link back to users table
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            // you can add more seller-specific fields here, e.g. shop_name
            $table->string('shop_name')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
