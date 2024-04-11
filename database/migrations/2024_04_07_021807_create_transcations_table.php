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
        Schema::create('transcations', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['in','out']);
            $table->float('quantity');
            $table->float('amount');
            $table->unsignedBigInteger('warehouse_id');
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('purchaseSale_id')->nullable();
            $table->unsignedBigInteger('office_id')->nullable();
            $table->date('created_date');
            $table->timestamps();

            $table->foreign('warehouse_id')->references('id') ->on('warehouses');
            
            $table->foreign('contact_id')->references('id') ->on('contacts');
            
            $table->foreign('product_id')->references('id') ->on('products');
            
            $table->foreign('user_id')->references('id') ->on('users');
            $table->foreign('office_id')->references('id') ->on('offices');
            $table->foreign('purchaseSale_id')->references('id') ->on('purchase_sales');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transcations');
    }
};
