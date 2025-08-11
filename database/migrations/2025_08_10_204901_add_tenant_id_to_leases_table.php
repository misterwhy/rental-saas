<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('leases', function (Blueprint $table) {
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('leases', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropColumn('tenant_id');
        });
    }
};