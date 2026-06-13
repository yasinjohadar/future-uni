<?php

namespace Database\Seeders;

use App\Models\LibrarySetting;
use Illuminate\Database\Seeder;

class LibrarySettingsSeeder extends Seeder
{
    public function run(): void
    {
        LibrarySetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'digital_references' => '850+',
                'reading_seats' => 320,
            ]
        );
    }
}
