<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('epackages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('cmsId');
            $table->string('cmsPackId');
            $table->string('mpn');
            $table->string('ean');
            $table->string('productName');
            $table->timestamps();

            $table->uuid('file_id');

            $table->foreign('file_id')
                ->references('id')
                ->on('files')
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
        Schema::dropIfExists('epackages');
    }
}
