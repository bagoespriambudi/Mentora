<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CurrencyExchangeService;

class UpdateExchangeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:update-rates 
                            {--clear-cache : Clear currency cache after updating}
                            {--force : Force update even if recently updated}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update currency exchange rates from external API';

    /**
     * Currency exchange service
     */
    private CurrencyExchangeService $currencyService;

    /**
     * Create a new command instance.
     */
    public function __construct(CurrencyExchangeService $currencyService)
    {
        parent::__construct();
        $this->currencyService = $currencyService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🚀 Starting currency exchange rate update...');
        
        try {
            // Clear cache if requested
            if ($this->option('clear-cache')) {
                $this->info('🧹 Clearing currency cache...');
                $this->currencyService->clearCache();
                $this->info('✅ Cache cleared successfully');
            }

            // Update exchange rates
            $this->info('📡 Fetching latest exchange rates...');
            $updated = $this->currencyService->updateDatabaseRates();

            if ($updated) {
                $this->info('✅ Exchange rates updated successfully!');
                
                // Clear cache after update to ensure fresh data
                if (!$this->option('clear-cache')) {
                    $this->currencyService->clearCache();
                    $this->info('🧹 Cache cleared to ensure fresh data');
                }
                
                $this->displayRatesInfo();
                return Command::SUCCESS;
            } else {
                $this->error('❌ Failed to update exchange rates');
                $this->warn('💡 This might be due to API limitations or network issues');
                return Command::FAILURE;
            }
            
        } catch (\Exception $e) {
            $this->error('💥 Error updating exchange rates: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * Display information about current rates
     */
    private function displayRatesInfo(): void
    {
        $this->info('📊 Current exchange rate information:');
        
        try {
            $rates = $this->currencyService->getCurrentRates('USD');
            
            if ($rates) {
                $this->table(
                    ['Currency', 'Rate to USD', 'Source'],
                    collect($rates['rates'])->take(10)->map(function ($rate, $currency) use ($rates) {
                        return [
                            $currency,
                            number_format($rate, 4),
                            $rates['source']
                        ];
                    })->toArray()
                );
                
                $this->info("🕒 Last updated: " . date('Y-m-d H:i:s', $rates['timestamp']));
                $this->info("📈 Total currencies: " . count($rates['rates']));
            }
            
        } catch (\Exception $e) {
            $this->warn('Could not display rate information: ' . $e->getMessage());
        }
    }
}
