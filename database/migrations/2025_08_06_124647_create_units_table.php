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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id'); // References properties.id
            $table->string('unit_number');
            $table->integer('bedrooms');
            $table->decimal('bathrooms', 3, 1); // e.g., 1, 1.5, 2
            $table->integer('square_footage');
            $table->decimal('rent_amount', 10, 2);
            $table->string('status'); // Occupied, Vacant, Under Maintenance
            $table->decimal('deposit_amount', 10, 2);
            $table->date('available_date')->nullable();
            // Make sure this is defined as a JSON column if your seeder/model expects an array
            $table->json('images')->nullable(); // Array of image URLs
            $table->timestamps();

            // Add the foreign key constraint
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};