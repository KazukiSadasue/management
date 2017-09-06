<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('project_id');
            $table->unsignedTinyInteger('type')->comment('1:出勤 2:午前休 3:午後休 4:全休');
            $table->string('employment')->comment('1:プログラミング作業 2:デザイン作業 3:仕様作業 4:テスト作業');
            $table->string('remarks')->nullable()->comment('備考');
            $table->date('day_at')->comment('働いた日');
            $table->time('start_at')->nullable()->comment('勤務開始');
            $table->time('finish_at')->nullable()->comment('勤務終了');
            $table->boolean('approval')->default('0')->comment('0:未承認 1:承認済');
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
        Schema::dropIfExists('work_schedules');
    }
}
