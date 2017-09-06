<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;
use Carbon\Carbon;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        $faker = Faker::create('ja_JP');

        for ($i = 0; $i < 500; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->email,
                'pref' => $faker->randomElement( array_keys(\Config("pref")) ),
                'password' => bcrypt($faker->password),
            ]);
        }
    }
}
