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
        Schema::create('supplier_service_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->string('count');
            $table->string('price');
            $table->string('total_items_cost');
            $table->foreignId('SSI_id')->constrained('supplier_service_invoices')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_service_invoice_items');
    }
};
