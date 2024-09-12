<?php

namespace Database\Seeders;

use App\Models\Trial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Trial::factory()->count(30)->create();
    }
}
