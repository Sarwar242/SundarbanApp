<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('image')->nullable();
            $table->date('dob')->nullable();
            $table->string('hn')->comment('holding_number')->nullable();
            $table->string('phone')->nullable();
            $table->string('nid')->nullable();
            $table->string('gender')->nullable();
            $table->string('street')->nullable();
            $table->string('village')->nullable();
            $table->string('zipcode')->nullable();

            $table->unsignedBigInteger('union_id')->nullable();
            $table->unsignedBigInteger('upazilla_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('division_id')->nullable();

            $table->timestamps();
            
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');

            $table->foreign('union_id')
            ->references('id')->on('unions')
            ->onDelete('set null');

            $table->foreign('upazilla_id')
            ->references('id')->on('upazillas')
            ->onDelete('set null');
            
            $table->foreign('district_id')
            ->references('id')->on('districts')
            ->onDelete('set null');

            $table->foreign('division_id')
            ->references('id')->on('divisions')
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
        Schema::dropIfExists('customers');
    }
}
