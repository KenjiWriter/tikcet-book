<?php

namespace App\Console\Commands;

use App\Models\Destination;
use Illuminate\Console\Command;

class CheckDestinationImages extends Command
{
    protected $signature = 'destinations:check-images';
    protected $description = 'Check destination images in database';

    public function handle()
    {
        $this->info('🔍 Sprawdzanie obrazów destynacji w bazie danych...');

        $destinations = Destination::all(['name', 'image']);

        foreach ($destinations as $destination) {
            $imageExists = $destination->image && file_exists(public_path($destination->image));
            $status = $imageExists ? '✅' : '❌';

            $this->line("{$status} {$destination->name} -> {$destination->image}");

            if (!$imageExists && $destination->image) {
                $this->warn("   Plik nie istnieje: " . public_path($destination->image));
            }
        }

        return Command::SUCCESS;
    }
}
