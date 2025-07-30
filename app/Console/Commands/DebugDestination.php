<?php

namespace App\Console\Commands;

use App\Models\Destination;
use Illuminate\Console\Command;

class DebugDestination extends Command
{
    protected $signature = 'destinations:debug {id=1}';
    protected $description = 'Debug destination data for show page';

    public function handle()
    {
        $id = $this->argument('id');
        $destination = Destination::find($id);

        if (!$destination) {
            $this->error("Destination with ID {$id} not found");
            return Command::FAILURE;
        }

        $this->info("=== DESTINATION DEBUG ===");
        $this->line("ID: {$destination->id}");
        $this->line("Name: {$destination->name}");
        $this->line("Description: {$destination->description}");

        $this->newLine();
        $this->info("=== HIGHLIGHTS ===");
        $this->line("Raw: " . $destination->highlights);
        $highlights = json_decode($destination->highlights, true);
        $this->line("Decoded: " . var_export($highlights, true));
        $this->line("Is array: " . (is_array($highlights) ? 'YES' : 'NO'));

        $this->newLine();
        $this->info("=== ACTIVITIES ===");
        $this->line("Raw: " . $destination->activities);
        $activities = json_decode($destination->activities, true);
        $this->line("Decoded: " . var_export($activities, true));
        $this->line("Is array: " . (is_array($activities) ? 'YES' : 'NO'));

        $this->newLine();
        $this->info("=== INCLUDED ===");
        $this->line("Raw: " . $destination->included);
        $included = json_decode($destination->included, true);
        $this->line("Decoded: " . var_export($included, true));
        $this->line("Is array: " . (is_array($included) ? 'YES' : 'NO'));

        $this->newLine();
        $this->info("=== NOT INCLUDED ===");
        $this->line("Raw: " . $destination->not_included);
        $notIncluded = json_decode($destination->not_included, true);
        $this->line("Decoded: " . var_export($notIncluded, true));
        $this->line("Is array: " . (is_array($notIncluded) ? 'YES' : 'NO'));

        return Command::SUCCESS;
    }
}
