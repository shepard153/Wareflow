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
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('warehouse_id');
            $table->integer('quantity');
            $table->date('arrival_date');
            $table->string('sender_name');
            $table->string('sender_address')->nullable();
            $table->string('tracking_number')->nullable();
            $table->timestamps();

            $table->foreign('sender_id')->references('id')->on('senders');
            $table->foreign('product_id')->references('id')->on('products');
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
