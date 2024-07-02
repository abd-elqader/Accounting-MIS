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
        Schema::create('supplier_product_invoice_taxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('SPI_id')->constrained('supplier_product_invoices')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Tax::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->float('value');
            $table->enum('value_type', ['percentage', 'amount']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_product_invoice_taxes');
    }
};
