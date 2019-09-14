<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Niels Vistisen';
        $user->email = 'nielswps@gmail.com';
        $user->password = Hash::make('123456789');
        $user->save();

        $user = new User();
        $user->name = 'Thomas Lorentzen';
        $user->email = 'thomas@tlorentzen.net';
        $user->password = Hash::make('246681');
        $user->save();
    }
}
