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
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->text('long_description')->nullable();
            $table->string('image');
            $table->decimal('price', 8, 2);
            $table->decimal('original_price', 8, 2)->nullable();
            $table->string('type');
            $table->string('duration');
            $table->decimal('rating', 3, 2);
            $table->json('activities');
            $table->json('highlights');
            $table->string('category');
            $table->string('difficulty')->default('medium');
            $table->string('season')->default('all');
            $table->json('gallery')->nullable();
            $table->json('included')->nullable();
            $table->json('not_included')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
