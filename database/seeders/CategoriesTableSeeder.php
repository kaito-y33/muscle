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
        $categories = [
            ['name' => '胸'],
            ['name' => '背中'],
            ['name' => '脚'],
            ['name' => '腕'],
            ['name' => '肩'],
            ['name' => '腹'],
            ['name' => '有酸素運動'],
            // 他のトレーニング部位をここに追加
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
