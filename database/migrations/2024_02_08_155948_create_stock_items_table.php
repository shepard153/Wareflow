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
        Schema::create('stock_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('warehouse_id');
            $table->unsignedBigInteger('shipment_id')->nullable();
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->integer('quantity');
            $table->string('batch_number')->nullable();
            $table->string('barcode')->nullable();
            $table->date('expiry_date')->nullable();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');
            $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade');
            $table->foreign('product_variation_id')->references('id')->on('product_variations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_items');
    }
};
