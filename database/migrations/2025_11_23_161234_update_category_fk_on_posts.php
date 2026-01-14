<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up()
        {
<<<<<<< HEAD
            if (!Schema::hasTable('posts')) {
=======
>>>>>>> b27e3ab4af188d781835f7d5dfe90a47a625a22f
            Schema::table('posts', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
                $table->foreign('category_id')
                    ->references('id')->on('categories')
                    ->onDelete('cascade');
            });
<<<<<<< HEAD
            }
=======
>>>>>>> b27e3ab4af188d781835f7d5dfe90a47a625a22f
        }

        public function down()
        {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
                $table->foreign('category_id')
                    ->references('id')->on('categories')
                    ->onDelete('set null');
            });
        }

};
