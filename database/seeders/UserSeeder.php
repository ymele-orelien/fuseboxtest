<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Commissioner Gordon',
                'email' => 'gordon@gothampd.com',
                'password' => Hash::make('237Cameroun'),
            ],
            [
                'name' => 'Ymele Orelien',
                'email' => 'test@gmail.com',
                'password' => Hash::make('123test'),
            ]
        ]);
    }
}
