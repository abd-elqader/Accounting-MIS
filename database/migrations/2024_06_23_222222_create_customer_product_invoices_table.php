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
        Schema::create('customer_product_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('total_invoice')->nullable();
            $table->string('reversed')->nullable();
            $table->string('due_date')->nullable();
            $table->string('creation_date')->nullable();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_product_invoices');
    }
};
