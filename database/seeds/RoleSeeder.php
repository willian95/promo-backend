<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Role::where("id", 1)->count() == 0){
            $role = new Role;
            $role->name = "Admin";
            $role->save();
        }

        if(Role::where("id", 2)->count() == 0){
            $role = new Role;
            $role->name = "User";
            $role->save();
        }
        

    }
}
