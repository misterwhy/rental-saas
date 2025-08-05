<?php
// database/migrations/xxxx_xx_xx_create_properties_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('zipcode');
            $table->decimal('price', 12, 2);
            $table->integer('bedrooms')->default(0);
            $table->integer('bathrooms')->default(0);
            $table->integer('area')->default(0);
            $table->string('type')->default('apartment');
            $table->string('status')->default('active');
            $table->boolean('featured')->default(false);
            $table->json('images')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for better performance
            $table->index(['status', 'featured']);
            $table->index(['city', 'type']);
            $table->index(['price']);
            $table->index(['user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('properties');
    }
};