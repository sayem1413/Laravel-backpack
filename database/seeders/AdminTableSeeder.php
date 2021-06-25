<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminData = [
            'name'      => 'Admin',
            'email'     => 'admin@gmail.com',
            'password'  => bcrypt('123456789'),
        ];
        $existingData = User::where('email', $adminData['email'])->first();
        if(!$existingData){
            User::create($adminData);
        }

    }
}
