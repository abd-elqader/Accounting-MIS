<?php

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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('contact_name')->nullable();
            $table->string('iban')->nullable();
            $table->string('commercial_register')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('taxable')->nullable();
            $table->string('company_name')->nullable();
            $table->string('monthly_expenses')->nullable();
            $table->string('monthly_income')->nullable();
            $table->foreignId('industry_id')->constrained()->onDelete('cascade');
            $table->foreignId('country_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('customers');
    }
};
