
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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id'); // Add this line
            $table->string('name');
            $table->text('address')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('country');
            $table->string('property_type'); // e.g., Residential, Commercial, HOA
            $table->integer('number_of_units');
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_price', 15, 2)->nullable();
            $table->text('description')->nullable();
            // Make sure these are defined as JSON columns if your seeder/model expects arrays
            $table->json('amenities')->nullable(); // e.g., ["Pool", "Gym", "Parking"]
            $table->json('images')->nullable();    // Array of image URLs
            $table->timestamps();

            // Add the foreign key constraint
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};