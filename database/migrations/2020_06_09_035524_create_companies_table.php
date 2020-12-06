<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('bn_name')->nullable();
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('code')->nullable();
            $table->time('open')->nullable();
            $table->time('close')->nullable();
            $table->string('off_day')->nullable();
            $table->string('owners_name')->nullable();
            $table->string('owners_nid')->nullable();
            $table->boolean('ban')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->boolean('phone_hide')->nullable()->default(0);
            $table->string('website')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->text('bn_description')->nullable();
            $table->string('business_type')->comment('Product|Service')->nullable();
            $table->string('type')->comment('Wholesale|Retail|Export|Import')->nullable();
            $table->string('location')->nullable();
            $table->string('bn_location')->nullable();
            $table->string('street')->nullable();
            $table->string('bn_street')->nullable();
            $table->string('zipcode')->nullable();

            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->unsignedBigInteger('union_id')->nullable();
            $table->unsignedBigInteger('upazilla_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('division_id')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
