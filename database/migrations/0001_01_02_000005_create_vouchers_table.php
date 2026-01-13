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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_store_id')->nullable()->constrained('branch_stores')->nullOnDelete();
            $table->foreignId('member_level_id')->nullable()->constrained('member_levels')->nullOnDelete();
            $table->string('code')->unique();
            $table->string('name');
            $table->enum('type', ['percent', 'amount']); // persen atau nominal
            $table->decimal('value', 10, 2); // nilai diskon
            $table->decimal('min_transaction', 12, 2)->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('quota')->nullable(); // jumlah pemakaian
            $table->integer('used')->default(0); // sudah dipakai
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
