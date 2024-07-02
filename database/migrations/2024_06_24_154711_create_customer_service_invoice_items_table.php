<?php

use App\Enum\ActivationStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_service_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->integer('count');
            $table->float('price');
            $table->float('total_items_cost');
            // $table->float('tax');
            // $table->boolean('taxable')->default(ActivationStatusEnum::ACTIVE);
            // $table->float('total_cost');
            $table->foreignId('CSI_id')->constrained('customer_service_invoices')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_service_invoice_items');
    }
};
