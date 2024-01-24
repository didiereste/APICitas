<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRol= Role::find(1);
        $clieteRol= Role::find(2);


        $adminUser = new User();
        $adminUser->name= "Usuario administrador";
        $adminUser->email= "admin@example.com";
        $adminUser->password= bcrypt("123456");
        $adminUser->save();
        $adminUser->assignRole($adminRol);

        $ClienteUser= new User();
        $ClienteUser->name="Usuario cliente";
        $ClienteUser->email="cliente@example.com";
        $ClienteUser->password= bcrypt("123456");
        $ClienteUser->assignRole($clieteRol);
        $ClienteUser->save();
    }
}
