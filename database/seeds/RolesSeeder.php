<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $roles = [
            ['id' => 1, 'role' => 'Client'],
            ['id' => 2, 'role' => 'Lawyer'],
            ['id' => 3, 'role' => 'Administrator'],
        ];

        Role::insert($roles);
    }
}
