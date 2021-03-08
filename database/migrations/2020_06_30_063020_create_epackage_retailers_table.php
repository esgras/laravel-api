<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpackageRetailersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('epackage_retailers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('skuId');
            $table->string('epackageLink');
            $table->string('epackage_id');
            $table->string('retailer_id');
            $table->timestamps();

            $table->unique(['epackage_id', 'retailer_id']);
            $table->unique(['skuId', 'retailer_id']);

            $table->foreign('epackage_id')
                ->on('epackages')
                ->references('id')
                ->onDelete('cascade');

            $table->foreign('retailer_id')
                ->on('retailers')
                ->references('id')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('epackage_retailers');
    }
}
