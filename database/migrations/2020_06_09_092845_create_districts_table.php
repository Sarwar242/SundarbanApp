<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('bn_name')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable(); 
            $table->string('website')->nullable(); 
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('division_id');
            $table->timestamps();

            $table->foreign('division_id')
            ->references('id')->on('divisions')
            ->onDelete('cascade');
            
            $table->foreign('admin_id')
            ->references('id')->on('admins')
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
        Schema::dropIfExists('districts');
    }
}
