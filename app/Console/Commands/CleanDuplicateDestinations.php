<?php

namespace App\Console\Commands;

use App\Models\Destination;
use Illuminate\Console\Command;

class CleanDuplicateDestinations extends Command
{
    protected $signature = 'destinations:clean-duplicates';
    protected $description = 'Remove duplicate destinations keeping only the first one';

    public function handle()
    {
        $this->info('🧹 Usuwanie duplikatów destynacji...');

        $destinationNames = ['Zakopane', 'Gdańsk', 'Kraków', 'Wrocław', 'Poznań', 'Karpacz'];

        foreach ($destinationNames as $name) {
            $destinations = Destination::where('name', $name)->get();

            if ($destinations->count() > 1) {
                $this->line("🔍 Znaleziono {$destinations->count()} duplikatów dla: {$name}");

                // Keep the first one, delete the rest
                $first = $destinations->first();
                $duplicates = $destinations->slice(1);

                foreach ($duplicates as $duplicate) {
                    $duplicate->delete();
                    $this->line("❌ Usunięto duplikat ID: {$duplicate->id}");
                }

                $this->line("✅ Zachowano {$name} (ID: {$first->id})");
            } else {
                $this->line("✅ {$name} - brak duplikatów");
            }
        }

        $totalDestinations = Destination::count();
        $this->info("🎉 Czyszczenie zakończone. Pozostało {$totalDestinations} destynacji.");

        return Command::SUCCESS;
    }
}
