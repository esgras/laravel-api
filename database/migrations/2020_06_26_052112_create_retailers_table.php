<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Entities\Retailer;

class CreateRetailersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retailers', function (Blueprint $table) {
            $productIdFieldValues = Retailer::PRODUCT_ID_FIELD_VALUES;

            $table->uuid('id')->primary();
            $table->string('name')->unique();
            $table->string('domain');
            $table->enum('productIdField', $productIdFieldValues)
                ->default(reset($productIdFieldValues));
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
        Schema::dropIfExists('retailers');
    }
}
