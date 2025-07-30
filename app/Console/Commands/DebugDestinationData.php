<?php

namespace App\Console\Commands;

use App\Models\Destination;
use Illuminate\Console\Command;

class DebugDestinationData extends Command
{
    protected $signature = 'debug:destination {id=1}';
    protected $description = 'Debug destination data types';

    public function handle()
    {
        $id = $this->argument('id');
        $destination = Destination::find($id);

        if (!$destination) {
            $this->error("Destination with ID {$id} not found");
            return;
        }

        $this->info("Destination: {$destination->name}");
        $this->line("Highlights type: " . gettype($destination->highlights));
        $this->line("Highlights value: " . $destination->highlights);
        $this->line("Activities type: " . gettype($destination->activities));
        $this->line("Activities value: " . $destination->activities);

        // Test JSON decode
        $highlights_decoded = json_decode($destination->highlights, true);
        $this->line("Highlights decoded: " . (is_array($highlights_decoded) ? 'SUCCESS' : 'FAILED'));
        if (is_array($highlights_decoded)) {
            $this->line("Highlights array: " . implode(', ', $highlights_decoded));
        }
    }
}
