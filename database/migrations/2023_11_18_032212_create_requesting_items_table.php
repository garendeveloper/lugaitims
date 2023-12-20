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
        Schema::create('requesting_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                    ->on('users')
                    ->references('id')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->unsignedBigInteger('movement_id');
            $table->foreign('movement_id')
                    ->on('movements')
                    ->references('id')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->tinyInteger('notification')->default(0);
            $table->integer('qty')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->longText('reasonforCancel')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requesting_items');
    }
};
