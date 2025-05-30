<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            // link back to users table
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            // add extra fields as needed, e.g. address
            $table->string('address')->nullable(false);

            //$table->string('address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
