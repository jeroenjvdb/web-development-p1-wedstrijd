<?php
use App\User;

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;

        $user->ip = "192.168.56.100";
        $user->email = "jeroen_vdb1@hotmail.com";
        $user->name = "Van den Broeck";
        $user->surname = "Jeroen";
        $user->password = Hash::make('test');
        $user->isAdmin = true;

       	$user->save();
    }
}
