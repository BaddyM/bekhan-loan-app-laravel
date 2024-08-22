<?php

namespace Database\Seeders;

use App\Models\User;
use Doctrine\Common\Lexer\Token;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        
        // User::factory(10)->create();
        $faker = Faker::create();

        /*
        $contacts = array('0781181958', '0708648398', '0773056259', '0705455877');

        foreach($contacts as $contact){
            $exists  = User::where('contact',$contact)->exists();
            if($exists != 1){
                User::factory()->create([
                    'username' => $faker->lastName." ".$faker->firstName,
                    'contact' => $contact,
                    'contact_verified_at' => now(),
                    'password' => Hash::make('1234')
                ]);
            }
        }
        */

        /*
        $year = date("Y",strtotime(now()));
        for($i=0; $i<=20; $i++){
            DB::table("loans_".$year."")->insert([
                'user_id' => 7,
                'loan_limit' => 100000,
                'loan_amount' => rand(10000, 100000),
                'loan_status' => 'paid',
                'created_at' => $faker->date
            ]);
        }
        */

        DB::table("support")->insert([
            'contact' => '0781181958, 0773056259',
            'email' => 'bekhan-extra-cash@gmail.com',
            'whatsapp' => '0708648398',
            'twitter' => '@bekhan_loan',
            'location' => 'kampala road',
            'created_at' => now()
        ]);
    }
}
