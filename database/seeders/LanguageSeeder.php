<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run()
    {
        $languages = [
            'English',
            'Romanian',
            'Spanish',
            'French',
            'German',
            'Chinese',
            'Japanese',
            'Russian',
            'Arabic',
            'Portuguese',
            'Hindi'
        ];

        foreach ($languages as $language) {
            Language::firstOrCreate(['name' => $language]);
        }
    }
}
