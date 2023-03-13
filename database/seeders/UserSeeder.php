<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i<10; $i++){
            $password = str::random(10);
            DB::table('users')->insert([
                'name' => str::random(10),
                'email' => Str::random(10).'@gmail.com',
                'password' => md5('1111'),
                'age' => $this->age(1950,2010),
            ]);
        }

    }

    private function age(int $max_birth_year, int $min_birth_year) : int
    {
        $year = rand($max_birth_year, $min_birth_year);
        $age = 2023 - $year;
        return $age;
    }

}
