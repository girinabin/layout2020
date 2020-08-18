<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $user = User::create([
            'name'=>'Admin',
            'email'=>'admin@admin',
            'password'=>Hash::make('test1234')
        ]);
        $user->roles()->create([
                'name'=>'Admin',
                'slug'=>'admin'
        ]);
        
    }
}
