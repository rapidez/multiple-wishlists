<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jb_wishlist', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id');
            $table->unsignedSmallInteger('store_id');
            $table->foreign('customer_id')->references('entity_id')->on('customer_entity')->cascadeOnDelete();
            $table->foreign('store_id')->references('store_id')->on('store');
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('shared')->default(false);
            $table->string('sharing_token')->unique();
            $table->timestamps();
        });

        Schema::create('jb_wishlist_item', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('wishlist_id');
            $table->unsignedInteger('product_id');
            $table->foreign('wishlist_id')->references('id')->on('jb_wishlist')->cascadeOnDelete();
            $table->foreign('product_id')->references('entity_id')->on('catalog_product_entity');
            $table->string('description')->nullable();
            $table->unsignedInteger('qty');
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
        Schema::dropIfExists('jb_wishlist');
        Schema::dropIfExists('jb_wishlist_item');
    }
};
