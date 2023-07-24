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
        Schema::create('outgoing_shipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('recipient_id');
            $table->unsignedBigInteger('carrier_id')->nullable();
            $table->unsignedBigInteger('warehouse_id');
            $table->integer('quantity');
            $table->date('shipment_date');
            $table->string('recipient_name');
            $table->string('recipient_address')->nullable();
            $table->string('tracking_number')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('recipient_id')->references('id')->on('recipients');
            $table->foreign('carrier_id')->references('id')->on('carriers');
            $table->foreign('warehouse_id')->references('id')->on('warehouses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outgoing_shipments');
    }
};
