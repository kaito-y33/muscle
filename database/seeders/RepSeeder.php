<?php

namespace Database\Seeders;

use App\Models\Rep;
use Illuminate\Database\Seeder;

class RepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rep::factory(3)->create();
    }
}
