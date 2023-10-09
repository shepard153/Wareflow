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
        Schema::create('shipment_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shipment_id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('location_id')->nullable();
            $table->string('item_type'); // To store the item type (product or product variation)
            $table->integer('quantity');
            $table->string('batch_number')->nullable();
            $table->string('barcode')->nullable();
            $table->date('expiry_date')->nullable();
            $table->timestamps();

            $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('product_locations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_items');
    }
};
