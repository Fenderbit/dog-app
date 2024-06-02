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
        Schema::create('user_dogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('dog_id');
            $table->string('name')->nullable();
            $table->decimal('health_level')->nullable();
            $table->decimal('hunger_level')->nullable();
            $table->string('image_url')->nullable();
            $table->decimal('price')->nullable();
            $table->timestamp('last_feeding_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_dogs');
    }
};
