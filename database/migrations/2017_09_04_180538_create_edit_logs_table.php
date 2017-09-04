<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEditLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edit_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('ユーザーID');
            $table->boolean('name')->comment('名前フラグ 0:未変更 1:変更')->default(false);
            $table->boolean('pref')->comment('住所フラグ 0:未変更 1:変更')->default(false);
            $table->boolean('image')->comment('画像フラグ 0:未変更 1:変更')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('edit_logs');
    }
}
