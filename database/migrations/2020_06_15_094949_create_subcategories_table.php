<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('bn_name')->nullable();
            $table->string('slug')->nullable();
            $table->unsignedTinyInteger('priority')->default(12);
            $table->boolean('featured')->default(false);
            $table->text('description')->nullable();
            $table->text('bn_description')->nullable();
            $table->string('image');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->timestamps();

            $table->foreign('admin_id')
            ->references('id')->on('admins')
            ->onDelete('set null');

            $table->foreign('category_id')
            ->references('id')->on('categories')
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
        Schema::dropIfExists('subcategories');
    }
}
