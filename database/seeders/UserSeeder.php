<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'June',
                'email' => 'june@mail.com',
                'password' => Hash::make('password'),
                'role_id' => 1,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'name' => 'July',
                'email' => 'july@mail.com',
                'password' => Hash::make('password'),
                'role_id' => 2,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'name' => 'August',
                'email' => 'august@mail.com',
                'password' => Hash::make('password'),
                'role_id' => 2,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
        ];

        $this->user->insert($users);

    }
}
