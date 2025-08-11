<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('leases', function (Blueprint $table) {
            // Add property_id column if it doesn't exist
            if (!Schema::hasColumn('leases', 'property_id')) {
                $table->foreignId('property_id')->constrained('properties')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('leases', function (Blueprint $table) {
            if (Schema::hasColumn('leases', 'property_id')) {
                $table->dropForeign(['property_id']);
                $table->dropColumn('property_id');
            }
        });
    }
};