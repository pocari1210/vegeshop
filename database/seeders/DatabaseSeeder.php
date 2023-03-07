<?php

namespace Database\Seeders;

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
    // ★$this->callで、作成したSeeder情報をDBに登録する★
    $this->call([
        OwnerSeeder::class,

    ]);
    }
}
