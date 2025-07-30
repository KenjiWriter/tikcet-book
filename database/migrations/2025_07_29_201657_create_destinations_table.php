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
            $table->text('long_description');
            $table->string('image')->nullable();
            $table->decimal('price', 8, 2);
            $table->decimal('original_price', 8, 2)->nullable();
            $table->string('type');
            $table->string('duration');
            $table->decimal('rating', 2, 1)->default(4.0);
            $table->json('activities');
            $table->json('highlights');
            $table->string('category');
            $table->string('difficulty');
            $table->string('season');
            $table->json('gallery')->nullable();
            $table->json('included');
            $table->json('not_included');
            $table->string('city');
            $table->string('region');
            $table->boolean('active')->default(true);
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
