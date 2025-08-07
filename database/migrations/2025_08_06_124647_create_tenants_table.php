
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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Add this line - references users.id
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->date('date_of_birth')->nullable();
            // Make sure this is defined as a JSON column if your seeder/model expects an array/object
            $table->json('emergency_contact')->nullable(); // name, relationship, phone, email
            $table->string('background_check_status')->default('Pending'); // Pending, Approved, Denied
            $table->integer('credit_score')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Add the foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};