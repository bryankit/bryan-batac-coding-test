<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            [
                ProductSeeder::class,
            ]
        );

        DB::table('users')->insert([
            'name' => 'bryan',
            'email' => 'batacbryankit@gmail.com',
            'email_verified_at' => now(),
            'password' => 'bryanPassword', // password
            'remember_token' => Str::random(10),
        ]);

        DB::table('personal_access_tokens')->insert([
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => 1,
            'name' => 'bryan',
            'token' => 'a735ce92773938243224aca96de63d285cbb083217600b3c9c3399597a39da8f'
        ]);


    }
}
