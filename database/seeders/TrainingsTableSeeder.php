<?php

namespace Database\Seeders;

use App\Models\Training;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Training::create([
            'name' => 'ベンチプレス',
            'description' => '胸大筋や三角筋など、上半身の筋肉を効率的に鍛えることができます。',
            'category_id' => 1,
        ]);

        Training::create([
            'name' => 'デッドリフト',
            'description' => '腰周りの筋肉やハムストリング、僧帽筋など、全身の筋肉を鍛えることができます。',
            'category_id' => 2,
        ]);

        Training::create([
            'name' => 'スクワット',
            'description' => '太ももやお尻などの筋肉を効率的に鍛えることができます。',
            'category_id' => 2,
        ]);

        Training::create([
            'name' => 'チンニング',
            'description' => '自重トレーニングの一つで、バーにぶら下がって行います。',
            'category_id' => 2,
        ]);

        Training::create([
            'name' => 'バーベルカール',
            'description' => 'バーベルを使って行います。',
            'category_id' => 4,
        ]);
    }
}
