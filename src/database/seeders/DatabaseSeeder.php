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
        \App\Models\User::factory(10) // 10ユーザーを生成
            ->has(\App\Models\Work::factory()->count(3) // 各ユーザーに3つのワークを関連付け
                ->has(\App\Models\Rest::factory()->count(2), 'rests')) // 各ワークに2つのレストを関連付け
            ->create();
    }
}
