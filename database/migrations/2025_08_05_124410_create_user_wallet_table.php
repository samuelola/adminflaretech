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
        Schema::create('user_wallet', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique()->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('currency_code')->nullable();
            $table->decimal('balance', 16, 2)->default(0);
            $table->decimal('minimium_balance', 16, 2)->default(0);
            $table->integer('status')->nullable();
            $table->integer('defaultt')->nullable();
            $table->integer('currency_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_wallet');
    }
};
