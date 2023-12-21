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
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplieritem_id');//Item Per Supplier
            $table->foreign('supplieritem_id')
                    ->references('id')
                    ->on('supplier_items')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                    ->on('users')
                    ->references('id')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->tinyInteger('notification')->default(0);
            $table->integer('qty')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->longText('reasonforCancel')->nullable();
            $table->date('dateReleased')->nullable();
            $table->date('datePurchased')->nullable();
            $table->date('dateWasted')->nullable();
            $table->date('dateCancelled')->nullable();
            // 1 = Requisition
            // 2 = Released
            // 3 = Purchased
            // 4 = Wasted
            $table->tinyInteger('type')->default(1);
            $table->longText('lastAction')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movements');
    }
};
