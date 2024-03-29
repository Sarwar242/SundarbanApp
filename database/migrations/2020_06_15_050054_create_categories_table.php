<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('bn_name')->nullable();
            $table->string('slug')->nullable();
            $table->unsignedTinyInteger('priority')->nullable()->default(12);
            $table->boolean('featured')->nullable()->default(false);
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->text('bn_description')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('image');
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
        Schema::dropIfExists('categories');
    }
}
