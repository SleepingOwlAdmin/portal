<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        factory(User::class, 10)->create();

        /** @var User $user */
        $user = factory(User::class)->create([
            'email' => 'admin@site.com',
            'password' => bcrypt('password'),
        ]);
    }
}