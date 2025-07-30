<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class CheckDestinationSchema extends Command
{
    protected $signature = 'destinations:check-schema';
    protected $description = 'Check destination table schema';

    public function handle()
    {
        $this->info('🔍 Sprawdzanie struktury tabeli destinations...');

        $columns = Schema::getColumnListing('destinations');

        $this->line('Kolumny w tabeli destinations:');
        foreach ($columns as $column) {
            $this->line("- {$column}");
        }

        // Check if required columns exist
        $requiredColumns = ['duration', 'max_people', 'min_age', 'itinerary', 'what_to_bring', 'cancellation_policy'];

        $this->line('');
        $this->info('Sprawdzanie wymaganych kolumn:');

        foreach ($requiredColumns as $column) {
            $exists = in_array($column, $columns);
            $status = $exists ? '✅' : '❌';
            $this->line("{$status} {$column}");
        }

        return Command::SUCCESS;
    }
}
