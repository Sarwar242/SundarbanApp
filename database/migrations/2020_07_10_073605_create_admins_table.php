<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('type')
                ->default('Super Admin')
                ->comment('Admin|Super Admin');
            $table->string('nid')->nullable();
            $table->boolean('ban')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('image')->nullable();
            $table->text('about')->nullable();
            $table->text('bn_about')->nullable();
            $table->string('location')->nullable();
            $table->string('bn_location')->nullable();
            $table->string('street')->nullable();
            $table->string('bn_street')->nullable();
            $table->string('zipcode')->nullable();

            $table->foreign('admin_id')
            ->references('id')->on('admins')
            ->onDelete('set null');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('union_id')->nullable();
            $table->unsignedBigInteger('upazilla_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('division_id')->nullable();

            $table->rememberToken();
            $table->timestamps();
             
            
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
        Schema::dropIfExists('admins');
    }
}
