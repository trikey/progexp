<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrCreate(['email' => 'belitskii@gmail.com'], [
            'password' => bcrypt('asdasd'),
            'is_admin' => 1,
        ]);
    }
}
