<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleId = DB::table('roles')->where('code', 'SYS_ADM')->first()->id;
        $regionId = DB::table('regions')->where('code', 'GRT-ACC')->first()->id;

        DB::table('users')->insert([
            'first_name' => 'Koachie',
            'last_name' => 'Admin',
            'role_id' => $roleId,
            'gender' => 'male',
            'region_id' => $regionId,
            'official_phone' => "0243045061",
            'username'=>'admin',
            'email'=>'koachie@health.com',
            'password' => bcrypt('admin123456'),
            'must_change_password' => false,
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
