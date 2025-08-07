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
        Schema::create('leases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id'); // Add this line - references units.id
            // tenant_ids is stored as JSON. Make sure the column type matches.
            $table->json('tenant_ids'); // Add this line - array of tenant IDs
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('rent_amount', 10, 2);
            $table->decimal('deposit_amount', 10, 2);
            $table->string('status'); // Active, Expired, Pending Renewal
            $table->string('payment_frequency'); // Monthly, Quarterly
            $table->string('late_fee_policy')->nullable();
            // Make sure this is defined as a JSON column if your seeder/model expects an array
            $table->json('documents')->nullable(); // Array of URLs to lease documents
            $table->date('last_payment_date')->nullable();
            $table->date('next_payment_due_date')->nullable();
            $table->timestamps();

            // Add the foreign key constraint for unit_id
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            // Note: tenant_ids is an array, so a direct foreign key constraint isn't typical here.
            // Validation should happen in the application logic.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leases');
    }
};