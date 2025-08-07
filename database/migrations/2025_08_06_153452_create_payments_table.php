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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lease_id'); // Add this line - references leases.id
            $table->unsignedBigInteger('tenant_id'); // Add this line - references tenants.id
            $table->decimal('amount', 10, 2); // Add this line
            $table->date('payment_date'); // Add this line
            $table->string('type'); // Rent, Late Fee, Deposit, Utility - Add this line
            $table->string('status'); // Paid, Pending, Failed, Refunded - Add this line
            $table->string('payment_method'); // Credit Card, ACH, Cash, Check - Add this line
            $table->string('transaction_id')->nullable(); // Add this line
            $table->text('notes')->nullable(); // Add this line
            $table->timestamps();

            // Add the foreign key constraints
            $table->foreign('lease_id')->references('id')->on('leases')->onDelete('cascade');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};