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
            $table->id();
            $table->string('sku',255);
            $table->string('brand',255);
            $table->integer('cat_id')->index;
            $table->decimal('old_price',8,2);
            $table->integer('discount_rate');
            $table->decimal('price',8,2);
            $table->decimal('cargo_price',8,2);
            $table->integer('stock');
            $table->decimal('star_avg',8,2);
            $table->integer('star_number');
            $table->timestamps();
            $table->softDeletes();
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
