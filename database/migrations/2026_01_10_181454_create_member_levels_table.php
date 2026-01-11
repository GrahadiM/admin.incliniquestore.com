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
        Schema::create('member_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Copper, Silver, Gold, Platinum, Diamond, Master
            $table->bigInteger('min_points')->default(0)->comment('Minimal point');
            $table->bigInteger('min_purchase')->default(0)->comment('Minimal pembelian');
            $table->bigInteger('min_payment')->default(0)->comment('Minimal pembayaran');
            $table->decimal('discount_percent', 5, 2)->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_levels');
    }
};
