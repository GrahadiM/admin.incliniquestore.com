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
        Schema::table('users', function (Blueprint $table) {
            $table->string('whatsapp')->nullable()->after('email');
            $table->enum('gender', ['male', 'female'])->nullable()->after('whatsapp');
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('active')->after('password');
            $table->foreignId('branch_store_id')->nullable()->after('id')->constrained('branch_stores')->nullOnDelete();
            $table->foreignId('member_level_id')->nullable()->after('branch_store_id')->constrained('member_levels')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
