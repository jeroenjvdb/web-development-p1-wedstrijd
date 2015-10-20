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

        $user->email = "jeroen_vdb1@hotmail.com";
        $user->name = "Jeroen Van den Broeck";
        $user->password = Hash::make('test');

       	$user->save();
    }
}
