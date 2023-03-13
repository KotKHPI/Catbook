<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCascadeDeleteToCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
//            $table->dropForeign(['cat_name_id']);
//            $table->foreign('cat_name_id')
//                ->references('id')
//                ->on('cat_names')
//                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
//            $table->dropForeign(['cat_name_id']);
//            $table->foreign('cat_name_id')
//                ->references('id')
//                ->on('cat_names');
        });
    }
}
