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
        Schema::create('supplier_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')
                    ->references('id')
                    ->on('suppliers')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')
                    ->references('id')
                    ->on('items')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
                    ->references('id')
                    ->on('itemcategories')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->text('modelnumber')->nullable();
            $table->text('serialnumber')->nullable();
            $table->integer('no_ofYears')->default(0)->nullable();
            $table->bigInteger('stock')->default(0);
            $table->integer('quantity');
            $table->double('cost', 8, 2);//price
            $table->string('totalCost');
            $table->string('remarks')->nullable();
            $table->date('date')->nullable();
            $table->tinyInteger('status')->default(0);//Determine if available or not.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_items');
    }
};
