<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_sheets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('project_id');
            $table->tinyInteger('work_type')->comment('1:出勤　2:午前休　3:午後休　4:全休');
            $table->tinyInteger('work_data')->comment('1:プログラム　2:デザイン　3:仕様　4:テスト');
            $table->string('remarks')->nullable()->comment('備考');
            $table->dateTime('start_work')->comment('勤務開始');
            $table->dateTime('finish_work')->comment('勤務終了');
            $table->boolean('approval')->default('0')->comment('0:一般 1:管理者');
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
        Schema::dropIfExists('work_sheets');
    }
}
