<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserToCatNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cat_names', function (Blueprint $table) {
//            $table->unsignedBigInteger('user_id'); //adding column with forign key after creating basic DB | pay attention to name {php artisan make:migration add_user_to_cat_names_table}

            if(env('DB_CONNECTION') === 'sqlite') {
                $table->unsignedBigInteger('user_id')->default(0);
            } else {
                $table->unsignedBigInteger('user_id');
            }


            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cat_names', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
