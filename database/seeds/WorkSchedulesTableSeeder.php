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

        $users = DB::table('users')->select('id')->get();
        foreach ($users as $user ) {
            $user_id[] = $user->id;
        }
        
        $projects = DB::table('projects')->select('id')->get();
        foreach ($projects as $project ) {
            $project_id[] = $project->id;
        }

        $faker = Faker::create('ja_JP');

        for ($i = 0; $i < 10000; $i++) {
            WorkSchedule::create([
                'user_id' => $faker->randomElement( $user_id ),
                'project_id' => $faker->randomElement( $project_id ),
                'type' => $faker->randomElement( array_keys(\Config("const.WORK_TYPE")) ),
                'employment' => $faker->randomElement( array_keys(\Config("const.EMPLOYMENT")) ),
                'day_at' => $faker->unique()->dateTimeBetween(Carbon::now()->subYear(5), Carbon::now()->addYear(5))->format('Y-m-d'),
                'start_at' => Carbon::createFromFormat('H:i:s', '10:00:00')->format('H:i:s'),
                'finish_at' => Carbon::createFromFormat('H:i:s', '19:00:00')->format('H:i:s'),
            ]);
        }
    }
}
