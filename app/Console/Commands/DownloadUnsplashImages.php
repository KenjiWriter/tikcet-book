<?php

namespace App\Console\Commands;

use App\Models\Destination;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DownloadUnsplashImages extends Command
{
    protected $signature = 'destinations:download-unsplash {--force : Force download even if images exist}';
    protected $description = 'Download themed images from Unsplash for destinations';

    public function handle()
    {
        $this->info('🖼️  Pobieranie obrazów z Unsplash dla destynacji...');

        $destinations = Destination::all();

        if ($destinations->isEmpty()) {
            $this->error('Brak destynacji w bazie danych. Uruchom najpierw seeder.');
            return Command::FAILURE;
        }

        // Create directory in public folder
        $destinationsDir = public_path('images/destinations');
        if (!file_exists($destinationsDir)) {
            mkdir($destinationsDir, 0755, true);
        }

        foreach ($destinations as $destination) {
            $this->info("📥 Pobieranie obrazów dla: {$destination->name}");

            try {
                $this->downloadThematicImages($destination);
                $this->line("✅ {$destination->name} - obrazy pobrane i baza zaktualizowana");
            } catch (\Exception $e) {
                $this->error("❌ Błąd przy pobieraniu obrazów dla {$destination->name}: " . $e->getMessage());
            }
        }

        $this->info('🎉 Wszystkie obrazy zostały pobrane!');

        // Clear cache
        $this->call('config:clear');
        $this->call('cache:clear');
        $this->call('view:clear');

        return Command::SUCCESS;
    }

    private function downloadThematicImages(Destination $destination)
    {
        $searchQuery = $this->getSearchQuery($destination->name);

        // Download main image
        $mainImagePath = $this->downloadImageFromUnsplash($destination, $searchQuery, 'main', 800, 600);

        if ($mainImagePath) {
            // Update database
            $destination->update([
                'image' => $mainImagePath
            ]);
        }

        // Download additional images (1-4)
        for ($i = 1; $i <= 4; $i++) {
            $this->downloadImageFromUnsplash($destination, $searchQuery, $i, 400, 300);
        }
    }

    private function downloadImageFromUnsplash(Destination $destination, string $searchQuery, $suffix, int $width = 800, int $height = 600): ?string
    {
        try {
            // Generate unique seed based on destination and suffix
            $seed = md5($destination->name . $suffix . $searchQuery);

            // Use Unsplash with specific search terms
            $unsplashUrl = "https://source.unsplash.com/{$width}x{$height}/?{$searchQuery}&sig=" . substr($seed, 0, 8);

            $this->line("🔗 Pobieranie: {$unsplashUrl}");

            // Download image
            $response = Http::timeout(30)->get($unsplashUrl);

            if ($response->successful()) {
                $filename = Str::slug($destination->name) . "-{$suffix}.jpg";
                $filepath = "images/destinations/{$filename}";
                $fullPath = public_path($filepath);

                file_put_contents($fullPath, $response->body());

                $this->line("💾 Zapisano: {$filepath}");
                return "/{$filepath}";
            } else {
                $this->warn("❌ HTTP {$response->status()} dla {$destination->name}-{$suffix}");
            }
        } catch (\Exception $e) {
            $this->warn("❌ Błąd pobierania {$destination->name}-{$suffix}: " . $e->getMessage());
        }

        return null;
    }

    private function getSearchQuery(string $destinationName): string
    {
        $queries = [
            'Zakopane' => 'zakopane,tatra,mountains,poland,snow',
            'Gdańsk' => 'gdansk,danzig,architecture,old,town,poland',
            'Kraków' => 'krakow,cracow,castle,medieval,poland,architecture',
            'Wrocław' => 'wroclaw,market,square,poland,colorful,houses',
            'Poznań' => 'poznan,town,hall,poland,architecture,market',
            'Karpacz' => 'karpacz,sudety,mountains,poland,nature'
        ];

        return $queries[$destinationName] ?? strtolower($destinationName) . ',poland,tourism,travel';
    }
}
