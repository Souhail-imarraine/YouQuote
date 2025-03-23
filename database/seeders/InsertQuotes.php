<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Quote;



class InsertQuotes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Quote::factory()->count(50)->create();
    }
}
