<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // insert in table Roles ok
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'user']);


        // create Permission
        Permission::create(['name' => 'create_quote']);
        Permission::create(['name' => 'edit-quote']);
        Permission::create(['name' => 'delete-quote']);


        // hna kan3tiwh les permission l admin wla l user
        $adminRole = Role::findByName('Admin');
        $adminRole->givePermissionTo(['create_quote','edit-quote', 'delete-quote']);

        $userRole = Role::findByName('user');
        $userRole->givePermissionTo(['create-quote']);


    }
}
