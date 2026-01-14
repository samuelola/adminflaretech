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
        if (!Schema::hasTable('posts')) {
        Schema::table('posts', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
        });
       }
=======
        Schema::table('posts', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
        });
>>>>>>> b27e3ab4af188d781835f7d5dfe90a47a625a22f
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            //
        });
    }
};
