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
<<<<<<< HEAD
        if (!Schema::hasTable('tags')) {
=======
>>>>>>> b27e3ab4af188d781835f7d5dfe90a47a625a22f
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });
<<<<<<< HEAD
        }
=======
>>>>>>> b27e3ab4af188d781835f7d5dfe90a47a625a22f
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
