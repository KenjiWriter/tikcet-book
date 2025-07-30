<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Destination;
use Illuminate\Support\Facades\File;

class FixDestinationImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'destinations:fix-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix destination images by converting to proper SVG files and updating database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 Naprawianie obrazów destynacji...');

        // Delete old .jpg files
        $imagesPath = public_path('images/destinations');
        $oldFiles = glob($imagesPath . '/*.jpg');
        foreach ($oldFiles as $file) {
            unlink($file);
        }
        $this->info('🗑️ Usunięto stare pliki .jpg');

        $colors = [
            'Zakopane' => '#2563eb', // blue
            'Gdańsk' => '#0891b2',   // cyan
            'Kraków' => '#dc2626',   // red
            'Wrocław' => '#7c3aed',  // violet
            'Poznań' => '#059669',   // emerald
            'Karpacz' => '#ea580c'   // orange
        ];

        $destinations = Destination::all();

        foreach ($destinations as $destination) {
            $color = $colors[$destination->name] ?? '#6b7280';

            // Generate main image as SVG
            $mainImagePath = '/images/destinations/' . strtolower($destination->name) . '-main.svg';
            $this->generateSVGImage(
                $destination->name,
                $color,
                400,
                300,
                public_path('images/destinations/' . strtolower($destination->name) . '-main.svg')
            );

            // Generate gallery images
            $galleryPaths = [];
            for ($i = 1; $i <= 4; $i++) {
                $galleryPath = '/images/destinations/' . strtolower($destination->name) . '-' . $i . '.svg';
                $galleryPaths[] = $galleryPath;
                $this->generateSVGImage(
                    $destination->name . ' #' . $i,
                    $color,
                    400,
                    300,
                    public_path('images/destinations/' . strtolower($destination->name) . '-' . $i . '.svg')
                );
            }

            // Update database with correct paths
            $destination->update([
                'image' => $mainImagePath,
                'gallery' => json_encode($galleryPaths)
            ]);

            $this->line("✓ {$destination->name} - obrazy wygenerowane i baza zaktualizowana");
        }

        $this->info('✅ Wszystkie obrazy zostały naprawione!');
        $this->info('🌐 Sprawdź: http://127.0.0.1:8000');
    }

    private function generateSVGImage($text, $color, $width, $height, $filepath)
    {
        $circleX = $width - 50;
        $circleY = $height - 50;

        $svg = <<<SVG
<svg width="{$width}" height="{$height}" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:{$color};stop-opacity:1" />
      <stop offset="100%" style="stop-color:#1f2937;stop-opacity:1" />
    </linearGradient>
  </defs>
  <rect width="100%" height="100%" fill="url(#grad)"/>
  <text x="50%" y="50%" font-family="Arial, sans-serif" font-size="24" font-weight="bold" fill="#ffffff" text-anchor="middle" dy=".3em">{$text}</text>
  <circle cx="50" cy="50" r="30" fill="rgba(255,255,255,0.2)"/>
  <circle cx="{$circleX}" cy="{$circleY}" r="20" fill="rgba(255,255,255,0.1)"/>
</svg>
SVG;

        File::put($filepath, $svg);
    }
}
