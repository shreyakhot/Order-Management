<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles=['admin','customer','user'];
        $len=count($roles);
        for ($i=0;$i<$len;$i++){
            $role=Role::firstOrCreate([
                'name' =>$roles[$i],
                //'guard_name' =>'api'
            ]);
        }
    }
}
