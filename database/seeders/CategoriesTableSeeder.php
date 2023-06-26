<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => '胸',
        ]);

        Category::create([
            'name' => '背中',
        ]);

        Category::create([
            'name' => '肩',
        ]);

        Category::create([
            'name' => '腕',
        ]);

        Category::create([
            'name' => '脚',
        ]);

        Category::create([
            'name' => '有酸素運動',
        ]);

        Category::create([
            'name' => 'コア',
        ]);

        Category::create([
            'name' => 'ストレッチ',
        ]);

        Category::create([
            'name' => 'その他',
        ]);
    }
}
