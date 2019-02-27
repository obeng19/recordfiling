<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('roles')->insert([
        'name' => 'System Administrator',
        'code' => 'SYS_ADM',
        'guard_name' => 'web',
        'created_at' => \Carbon\Carbon::now()
    ]);
        DB::table('roles')->insert([
            'name' => 'Administrator',
            'code' => 'ADM_MAIN',
            'guard_name' => 'web',
            'created_at' => \Carbon\Carbon::now()
        ]);
        DB::table('roles')->insert([
            'name' => 'User',
            'code' => 'USR_U',
            'guard_name' => 'web',
            'created_at' => \Carbon\Carbon::now()
        ]);

    }

}
