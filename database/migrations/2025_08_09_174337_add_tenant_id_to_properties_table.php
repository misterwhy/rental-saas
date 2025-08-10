<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            if (!Schema::hasColumn('properties', 'tenant_id')) {
                $table->unsignedBigInteger('tenant_id')->nullable()->after('owner_id');
                $table->foreign('tenant_id')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropColumn('tenant_id');
        });
    }
};