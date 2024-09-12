<?php

namespace Database\Seeders;

use App\Models\LegalCase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LegalCaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LegalCase::factory()
            ->count(50)
            ->withTags()
            ->create();
    }
}
