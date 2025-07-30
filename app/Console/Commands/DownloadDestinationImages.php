<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Destination;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class DownloadDestinationImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'destinations:download-images {--fresh : Delete existing images first}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download real images from internet for destinations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🖼️  Pobieranie prawdziwych zdjęć dla destynacji...');

        if ($this->option('fresh')) {
            $this->info('🗑️  Usuwanie starych obrazów...');
            $this->deleteExistingImages();
        }

        $destinations = Destination::all();

        if ($destinations->isEmpty()) {
            $this->error('❌ Brak destynacji w bazie danych. Uruchom najpierw seeder.');
            return 1;
        }

        $destinationsDir = public_path('images/destinations');
        if (!File::exists($destinationsDir)) {
            File::makeDirectory($destinationsDir, 0755, true);
        }

        foreach ($destinations as $destination) {
            $this->info("📥 Pobieranie obrazów dla: {$destination->name}");

            try {
                $this->downloadImageSet($destination);
                $this->line("✅ {$destination->name} - obrazy pobrane i baza zaktualizowana");
            } catch (\Exception $e) {
                $this->error("❌ Błąd przy pobieraniu obrazów dla {$destination->name}: " . $e->getMessage());
            }
        }

        $this->info('🎉 Wszystkie obrazy zostały pobrane!');
        $this->line('💡 Sprawdź katalog public/images/destinations/');

        return 0;
    }

    private function deleteExistingImages()
    {
        $destinationsDir = public_path('images/destinations');
        if (File::exists($destinationsDir)) {
            File::deleteDirectory($destinationsDir);
            File::makeDirectory($destinationsDir, 0755, true);
        }
    }

    private function downloadImageSet(Destination $destination)
    {
        $searchTerm = $this->getSearchTerm($destination->name);
        $images = [];

        // Pobierz główny obraz (main)
        $mainImagePath = $this->downloadImage($searchTerm, $destination->name, 'main', 800, 600);
        if ($mainImagePath) {
            $images['main'] = $mainImagePath;
        }

        // Pobierz 4 dodatkowe obrazy (1-4)
        for ($i = 1; $i <= 4; $i++) {
            $imagePath = $this->downloadImage($searchTerm, $destination->name, $i, 400, 300);
            if ($imagePath) {
                $images[$i] = $imagePath;
            }
        }

        // Aktualizuj bazę danych z głównym obrazem
        if (!empty($images['main'])) {
            $destination->update([
                'image' => $images['main']
            ]);
        }
    }

    private function downloadImage($searchTerm, $destinationName, $suffix, $width = 800, $height = 600)
    {
        try {
            // Używamy Picsum API (zawsze działa)
            $picsumUrl = "https://picsum.photos/{$width}/{$height}";

            $this->line("🔗 Pobieranie: {$picsumUrl}");

            // Pobierz obraz
            $response = Http::timeout(15)->get($picsumUrl);

            if ($response->successful()) {
                $filename = strtolower(str_replace(['ą', 'ć', 'ę', 'ł', 'ń', 'ó', 'ś', 'ź', 'ż'],
                                                  ['a', 'c', 'e', 'l', 'n', 'o', 's', 'z', 'z'],
                                                  $destinationName));
                $filename = preg_replace('/[^a-z0-9\-]/', '', $filename);
                $filepath = "images/destinations/{$filename}-{$suffix}.jpg";
                $fullPath = public_path($filepath);

                File::put($fullPath, $response->body());

                $this->line("💾 Zapisano: {$filepath}");
                return "/{$filepath}";
            } else {
                $this->warn("❌ HTTP {$response->status()} dla {$destinationName}-{$suffix}");
            }
        } catch (\Exception $e) {
            $this->warn("❌ Błąd pobierania {$destinationName}-{$suffix}: " . $e->getMessage());
        }

        return null;
    }

    private function getSearchTerm($destinationName)
    {
        $searchTerms = [
            'Zakopane' => 'zakopane,tatry,mountains,poland',
            'Gdańsk' => 'gdansk,danzig,baltic,poland,architecture',
            'Kraków' => 'krakow,cracow,poland,medieval,castle',
            'Wrocław' => 'wroclaw,poland,market,square,architecture',
            'Poznań' => 'poznan,poland,town,hall,architecture',
            'Karpacz' => 'karpacz,sudety,mountains,poland'
        ];

        return $searchTerms[$destinationName] ?? strtolower($destinationName) . ',poland,tourism';
    }
}
