<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('code');
            $table->string('slug')->nullable();
            $table->string('bn_name')->nullable();
            $table->string('description')->nullable();
            $table->string('bn_description')->nullable();
            $table->double('price')->default(0);
            $table->double('discount')->nullable();
            $table->double('quantity')->nullable();
            $table->string('type')->comment('Featured|Normal')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            
            $table->timestamps();


            $table->foreign('admin_id')
            ->references('id')->on('admins')
            ->onDelete('set null');
            
            $table->foreign('category_id')
            ->references('id')->on('categories')
            ->onDelete('set null');

            $table->foreign('subcategory_id')
            ->references('id')->on('subcategories')
            ->onDelete('set null');

            $table->foreign('unit_id')
            ->references('id')->on('units')
            ->onDelete('set null');

            $table->foreign('company_id')
            ->references('id')->on('companies')
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
        Schema::dropIfExists('products');
    }
}
