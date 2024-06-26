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
        Schema::create('purchase_sales', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['purchase', 'sale']);
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('office_id')->nullable();
            $table->foreign('contact_id')->references('id')->on('contacts');
            $table->foreign('office_id')->references('id')->on('offices');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_sales');
    }
};
