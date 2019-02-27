<?php

use Illuminate\Database\Seeder;

class RegionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regions')->insert([
            'name' => 'Greater Accra',
            'code' => 'GRT-ACC',
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
