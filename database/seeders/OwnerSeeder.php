<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// ★DBファザードを使えるようにする★
use Illuminate\Support\Facades\DB;
// Hashファザードを使えるようにする
use Illuminate\Support\Facades\Hash;
// shopを扱えるようにする
use App\Models\Shop;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    // パスワードなどハッシュ化するために
    // Hash::makeを()用いる
    
    public function run()
    {
        DB::table('owners')->insert([
            [
                'name' => 'test1',
                'email' => 'test1@test.com',
                'password' => Hash::make('password123'),
                'created_at' => '2021/01/01 11:11:11'    
            ],
        ]);
    }
}