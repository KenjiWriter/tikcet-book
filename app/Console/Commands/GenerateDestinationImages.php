<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Destination;
use Illuminate\Support\Facades\File;

class GenerateDestinationImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'destinations:generate-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate placeholder images for destinations with proper layouts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generowanie obrazów dla destynacji...');

        // Create images directory if it doesn't exist
        $imagesPath = public_path('images/destinations');
        if (!File::exists($imagesPath)) {
            File::makeDirectory($imagesPath, 0755, true);
        }

        $destinations = Destination::all();

        foreach ($destinations as $destination) {
            $this->generateImageSet($destination);
        }

        $this->info('✅ Wszystkie obrazy zostały wygenerowane!');
    }

    private function generateImageSet(Destination $destination)
    {
        $colors = [
            'Zakopane' => '#2563eb', // blue
            'Gdańsk' => '#0891b2',   // cyan
            'Kraków' => '#dc2626',   // red
            'Wrocław' => '#7c3aed',  // violet
            'Poznań' => '#059669',   // emerald
            'Karpacz' => '#ea580c'   // orange
        ];

        $color = $colors[$destination->name] ?? '#6b7280';

        // Generate main image
        $this->generateSVGImage(
            $destination->name,
            $color,
            400,
            300,
            str_replace('/images/destinations/', '', str_replace('.jpg', '.svg', $destination->image))
        );

        // Generate gallery images
        $gallery = json_decode($destination->gallery, true);
        if ($gallery) {
            foreach ($gallery as $index => $imagePath) {
                $filename = str_replace('/images/destinations/', '', str_replace('.jpg', '.svg', $imagePath));
                $this->generateSVGImage(
                    $destination->name . ' #' . ($index + 1),
                    $color,
                    400,
                    300,
                    $filename
                );
            }
        }

        $this->line("✓ Obrazy dla {$destination->name} zostały wygenerowane");
    }

    private function generateSVGImage($text, $color, $width, $height, $filename)
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

        $filepath = public_path('images/destinations/' . $filename);
        File::put($filepath, $svg);
    }
}
