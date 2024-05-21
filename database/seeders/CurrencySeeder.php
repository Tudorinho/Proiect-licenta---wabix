<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CurrencySeeder extends Seeder
{
    public function run()
    {
        $currencies = [
            [
                'name' => 'Euro',
                'symbol' => 'EUR',
                'is_default' => 1,
                'rate' => 1
            ],
            [
                'name' => 'US Dollar',
                'symbol' => 'USD',
                'is_default' => 0,
                'rate' => 1.08
            ],
            [
                'name' => 'Romanian Leu',
                'symbol' => 'RON',
                'is_default' => 0,
                'rate' => 4.97
            ],
        ];

        foreach($currencies as $currency){
            DB::table('currencies')->insert([
                'name' => $currency['name'],
                'symbol' => $currency['symbol'],
                'is_default' => $currency['is_default'],
                'rate' => $currency['rate']
            ]);
        }
    }
}
