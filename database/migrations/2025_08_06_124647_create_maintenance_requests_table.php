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
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id'); // Add this line - references units.id
            $table->unsignedBigInteger('tenant_id')->nullable(); // Add this line - references tenants.id
            $table->string('title'); // Add this line
            $table->text('description'); // Add this line
            $table->string('priority'); // Low, Medium, High - Add this line
            $table->string('status'); // Open, In Progress, Completed, Cancelled - Add this line
            $table->unsignedBigInteger('assigned_to')->nullable(); // Add this line - references users.id (staff)
            // Make sure this is defined as a JSON column if your seeder/model expects an array
            $table->json('images')->nullable(); // Array of image URLs - Add this line
            $table->timestamps();

            // Add the foreign key constraints
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('set null');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
            // Note: If you want to reference the Property directly as well, you could add a property_id column,
            // but it's often derivable from unit_id.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};