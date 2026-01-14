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
        if (!Schema::hasTable('post_tag')) {
=======
>>>>>>> b27e3ab4af188d781835f7d5dfe90a47a625a22f
        Schema::create('post_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('post_tag');
    }
};
