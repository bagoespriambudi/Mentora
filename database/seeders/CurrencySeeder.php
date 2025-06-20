<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Currency;
use Carbon\Carbon;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            [
                'code' => 'IDR',
                'name' => 'Indonesian Rupiah',
                'symbol' => 'Rp',
                'rate_to_usd' => 15420.00, // 1 USD = 15,420 IDR (approximate)
                'is_active' => true,
                'is_base_currency' => true, // Set IDR as base for Indonesian platform
                'decimal_places' => 0, // Indonesian Rupiah doesn't use decimals
                'last_updated' => Carbon::now()
            ],
            [
                'code' => 'USD',
                'name' => 'US Dollar',
                'symbol' => '$',
                'rate_to_usd' => 1.000000, // Base rate
                'is_active' => true,
                'is_base_currency' => false,
                'decimal_places' => 2,
                'last_updated' => Carbon::now()
            ],
            [
                'code' => 'EUR',
                'name' => 'Euro',
                'symbol' => '€',
                'rate_to_usd' => 0.85, // 1 USD = 0.85 EUR (approximate)
                'is_active' => true,
                'is_base_currency' => false,
                'decimal_places' => 2,
                'last_updated' => Carbon::now()
            ],
            [
                'code' => 'GBP',
                'name' => 'British Pound Sterling',
                'symbol' => '£',
                'rate_to_usd' => 0.73, // 1 USD = 0.73 GBP (approximate)
                'is_active' => true,
                'is_base_currency' => false,
                'decimal_places' => 2,
                'last_updated' => Carbon::now()
            ],
            [
                'code' => 'JPY',
                'name' => 'Japanese Yen',
                'symbol' => '¥',
                'rate_to_usd' => 110.00, // 1 USD = 110 JPY (approximate)
                'is_active' => true,
                'is_base_currency' => false,
                'decimal_places' => 0, // JPY doesn't use decimals
                'last_updated' => Carbon::now()
            ],
            [
                'code' => 'SGD',
                'name' => 'Singapore Dollar',
                'symbol' => 'S$',
                'rate_to_usd' => 1.35, // 1 USD = 1.35 SGD (approximate)
                'is_active' => true,
                'is_base_currency' => false,
                'decimal_places' => 2,
                'last_updated' => Carbon::now()
            ],
            [
                'code' => 'MYR',
                'name' => 'Malaysian Ringgit',
                'symbol' => 'RM',
                'rate_to_usd' => 4.20, // 1 USD = 4.20 MYR (approximate)
                'is_active' => true,
                'is_base_currency' => false,
                'decimal_places' => 2,
                'last_updated' => Carbon::now()
            ],
            [
                'code' => 'THB',
                'name' => 'Thai Baht',
                'symbol' => '฿',
                'rate_to_usd' => 33.50, // 1 USD = 33.50 THB (approximate)
                'is_active' => true,
                'is_base_currency' => false,
                'decimal_places' => 2,
                'last_updated' => Carbon::now()
            ],
            [
                'code' => 'PHP',
                'name' => 'Philippine Peso',
                'symbol' => '₱',
                'rate_to_usd' => 56.00, // 1 USD = 56 PHP (approximate)
                'is_active' => true,
                'is_base_currency' => false,
                'decimal_places' => 2,
                'last_updated' => Carbon::now()
            ],
            [
                'code' => 'VND',
                'name' => 'Vietnamese Dong',
                'symbol' => '₫',
                'rate_to_usd' => 24000.00, // 1 USD = 24,000 VND (approximate)
                'is_active' => true,
                'is_base_currency' => false,
                'decimal_places' => 0, // VND doesn't use decimals
                'last_updated' => Carbon::now()
            ],
            [
                'code' => 'AUD',
                'name' => 'Australian Dollar',
                'symbol' => 'A$',
                'rate_to_usd' => 1.35, // 1 USD = 1.35 AUD (approximate)
                'is_active' => true,
                'is_base_currency' => false,
                'decimal_places' => 2,
                'last_updated' => Carbon::now()
            ],
            [
                'code' => 'CAD',
                'name' => 'Canadian Dollar',
                'symbol' => 'C$',
                'rate_to_usd' => 1.25, // 1 USD = 1.25 CAD (approximate)
                'is_active' => true,
                'is_base_currency' => false,
                'decimal_places' => 2,
                'last_updated' => Carbon::now()
            ],
            [
                'code' => 'CHF',
                'name' => 'Swiss Franc',
                'symbol' => 'CHF',
                'rate_to_usd' => 0.92, // 1 USD = 0.92 CHF (approximate)
                'is_active' => true,
                'is_base_currency' => false,
                'decimal_places' => 2,
                'last_updated' => Carbon::now()
            ],
            [
                'code' => 'CNY',
                'name' => 'Chinese Yuan',
                'symbol' => '¥',
                'rate_to_usd' => 7.20, // 1 USD = 7.20 CNY (approximate)
                'is_active' => true,
                'is_base_currency' => false,
                'decimal_places' => 2,
                'last_updated' => Carbon::now()
            ],
            [
                'code' => 'INR',
                'name' => 'Indian Rupee',
                'symbol' => '₹',
                'rate_to_usd' => 83.00, // 1 USD = 83 INR (approximate)
                'is_active' => true,
                'is_base_currency' => false,
                'decimal_places' => 2,
                'last_updated' => Carbon::now()
            ]
        ];

        foreach ($currencies as $currency) {
            Currency::updateOrCreate(
                ['code' => $currency['code']],
                $currency
            );
        }

        $this->command->info('Currency seeder completed successfully!');
        $this->command->info('Total currencies added: ' . count($currencies));
        $this->command->info('Base currency: IDR (Indonesian Rupiah)');
    }
}
