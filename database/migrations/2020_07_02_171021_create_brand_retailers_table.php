<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandRetailersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_retailers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('retailer_id');
            $table->uuid('brand_id');
            $table->boolean('active')->default(false);
            $table->timestamps();

            $table->unique(['retailer_id', 'brand_id']);

            $table->foreign('retailer_id')
                ->on('retailers')
                ->references('id')
                ->onDelete('CASCADE');

            $table->foreign('brand_id')
                ->on('brands')
                ->references('id')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brand_retailers');
    }
}
