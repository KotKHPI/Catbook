<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameCatNameTagTableToTaggables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cat_name_tag', function (Blueprint $table) {
            $table->dropForeign(['cat_name_id']);
            $table->dropColumn('cat_name_id');
        });

        Schema::rename('cat_name_tag', 'taggables');

        Schema::table('taggables', function (Blueprint $table) {
            $table->morphs('taggable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('taggables', function (Blueprint $table) {
            $table->dropMorphs('taggable');
        });

        Schema::rename('taggables', 'cat_name_tag');

        Schema::disableForeignKeyConstraints();

        Schema::table('cat_name_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('cat_name_id')->index();
            $table->foreign('cat_name_id')->references('id')
                ->on('cat_names')
                ->onDelete('cascade');
        });

        Schema::enableForeignKeyConstraints();
    }
}
