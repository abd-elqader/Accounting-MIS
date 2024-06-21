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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand');
            $table->float('tax');
            $table->boolean('taxable')->default(ActivationStatusEnum::ACTIVE);
            $table->string('description');
            $table->integer('stock');
            // $table->string('type');
            $table->float('daily_income');
            $table->float('weekly_income');
            $table->float('monthly_income');
            $table->float('yearly_income');
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
        Schema::dropIfExists('services');
    }
};
