<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;
use Carbon\Carbon;
use App\Models\WorkSchedule;

class WorkSchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('work_schedules')->delete();

        //ユーザーID配列の用意（fakerで使用）
        $users = DB::table('users')->select('id')->get()->toArray();

        //プロジェクトID配列の用意（fakerで使用）
        $projects = DB::table('projects')->select('id')->get();
        foreach ($projects as $project ) {
            $project_ids[] = $project->id;
        }

        $faker = Faker::create('ja_JP');

        for ($i = 1; $i <= 10000; $i++) {
            $user_id = $faker->randomElement( array_column($users, 'id') );

            //作成したダミーユーザーが重複していたら、ユニークなday_atを作成
            $duplication_user_datas = DB::table('work_schedules')->select('day_at', 'user_id')->where('user_id', '=', $user_id)->get();
            if ( isset($duplication_user_datas[0]) ) {
                $flag = true;
                while ($flag) {
                    $flag = false;
                    $day_at = $faker->dateTimeBetween(Carbon::now()->subYear(30), Carbon::now()->addYear(30))->format('Y-m-d');
                    foreach ($duplication_user_datas as $data ) {
                        if ($data->day_at == $day_at) {
                            $flag = true;
                            break;
                        }
                    }
                }
            } else {
                $day_at = $faker->dateTimeBetween(Carbon::now()->subYear(30), Carbon::now()->addYear(30))->format('Y-m-d');
            }
            
            
            $type = $faker->randomElement( array_keys(\Config("const.WORK_TYPE")) );
          
            //タイプごとに出勤時間ダミーデータを作成
            if ( $type == 1 ) {
                $start_at = Carbon::createFromFormat('H:i:s', '10:00:00')->format('H:i:s');
                $finish_at = $faker->dateTimeBetween( $day_at.' 19:00:00', $day_at.' 23:59:00' )->format('H:i:s');
            }
            if ( $type == 2 ) {
                $start_at = Carbon::createFromFormat('H:i:s', '15:00:00')->format('H:i:s');
                $finish_at = $faker->dateTimeBetween( $day_at.' 19:00:00', $day_at.' 23:59:00' )->format('H:i:s');
            }
            if ( $type == 3 ) {
                $start_at = Carbon::createFromFormat('H:i:s', '10:00:00')->format('H:i:s');
                $finish_at = Carbon::createFromFormat('H:i:s', '15:00:00')->format('H:i:s');
            }
            if ( $type == 4 ) {
                $start_at = null;
                $finish_at = null;
            }

            //employment 作成
            $element_count = $faker->numberBetween( 1, count(\Config("const.EMPLOYMENT")) );
            $employments = $faker->randomElements( array_keys(\Config("const.EMPLOYMENT")), $element_count );
            
            //ダミー作成
            WorkSchedule::create([
                'user_id' => $user_id,
                'project_id' => $faker->randomElement( $project_ids ),
                'type' => $type,
                'employment' => implode(',', $employments),
                'day_at' => $day_at,
                'start_at' => $start_at,
                'finish_at' => $finish_at,
            ]);
        }
    }
}
