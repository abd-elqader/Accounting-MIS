<?php

use App\Enum\InvoiceReverseStatusEnum;
use Carbon\Carbon;
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
        Schema::create('supplier_product_invoices', function (Blueprint $table) {
            $table->id();
            $table->float('total_invoice')->default(0);
            $table->enum('reversed', [InvoiceReverseStatusEnum::REVERSED, InvoiceReverseStatusEnum::NOT_REVERSED])->default(InvoiceReverseStatusEnum::NOT_REVERSED);
            $table->date('due_date');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Currency::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_product_invoices');
    }
};
