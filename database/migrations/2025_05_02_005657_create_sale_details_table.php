<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('name_product');
            $table->integer('quantity');
            $table->unsignedBigInteger('sale_id')->nullable();
            
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('sale_id')
                ->references('id')->on('sales')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_details');
    }
};
