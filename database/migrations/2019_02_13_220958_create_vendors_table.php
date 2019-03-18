<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ptr_vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->unique('name');
            $table->string('mobile_no')->nullable;
            $table->string('email')->nullable;
            $table->boolean('active')->default(false);
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
        Schema::dropIfExists('ptr_vendors');
    }
}
