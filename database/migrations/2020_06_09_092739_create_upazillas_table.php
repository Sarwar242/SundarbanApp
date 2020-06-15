<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpazillasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upazillas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bn_name')->nullable();
            $table->string('name')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable(); 
            $table->unsignedBigInteger('district_id')->nullable();
            $table->timestamps();

            $table->foreign('district_id')
            ->references('id')->on('districts')
            ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upazillas');
    }
}
