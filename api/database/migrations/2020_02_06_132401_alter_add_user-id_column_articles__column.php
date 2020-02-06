<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddUserIdColumnArticlesColumn extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('user_id');
        });
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}
