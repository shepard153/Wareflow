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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('warehouse_id');

            $table->integer('quantity');
            $table->text('description')->nullable();
            $table->string('reference')->nullable();
            $table->string('tracking_number')->nullable();

            $table->enum('shipment_type', ['incoming', 'outgoing', 'warehouse_transfer']);
            $table->enum('status', [
                'created', 'pending', 'on_hold', 'in_transit', 'delivered', 'canceled'
            ])->default('created');

            $table->date('scheduled_date')->nullable();
            $table->date('shipment_date')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('contact_id')->references('id')->on('contacts');
            $table->foreign('warehouse_id')->references('id')->on('warehouses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
