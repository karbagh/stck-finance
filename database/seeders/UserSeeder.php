<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;

final class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->upsert([
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@mail.com',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('password'),
            ]
        ], ['email']);
    }
}
