<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('bn_name')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable(); 
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('upazilla_id')->nullable();
            $table->timestamps();

            $table->foreign('admin_id')
            ->references('id')->on('admins')
            ->onDelete('set null');

    
            $table->foreign('upazilla_id')
            ->references('id')->on('upazillas')
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
        Schema::dropIfExists('unions');
    }
}
