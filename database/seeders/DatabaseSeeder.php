<?php

namespace Database\Seeders;

use Database\Seeders\CountrySeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(CurrencySeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(IndustrySeeder::class);
    }
}
