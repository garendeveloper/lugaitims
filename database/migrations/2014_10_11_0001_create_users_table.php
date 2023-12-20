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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // 1 = admin 
            // 2 = purchaser
            $table->tinyInteger('role');
            $table->unsignedBigInteger('position_id');
            $table->foreign('position_id')
                ->references('id')
                ->on('positions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            // $table->unsignedBigInteger('address_id');
            // $table->foreign('address_id')
            //     ->references('id')
            //     ->on('addresses')
            //     ->onUpdate('cascade')
            //     ->onDelete('cascade');
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('email')->nullable();
            $table->string('email_verified_at')->nullable();
            $table->string('fullname');
            $table->string('contact_number');
            $table->string('username');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
