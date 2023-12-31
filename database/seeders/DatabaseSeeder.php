<?php

namespace Database\Seeders;

use App\Http\Controllers\TestController;
use App\Services\gender\GenderServiceImpl;
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

        $this->call([
            CountryTableSeeder::class,
            CityTableSeeder::class,
            CurrencyTableSeeder::class,
            UserTableSeeder::class,
            PageInfoTableSeeder::class,
        ]);
        (new GenderServiceImpl())->add(json_decode(json_encode(['name'=>"Masculino"])));
        (new GenderServiceImpl())->add(json_decode(json_encode(['name'=>"Feminino"])));

        (new TestController())->modules();
    }
}
