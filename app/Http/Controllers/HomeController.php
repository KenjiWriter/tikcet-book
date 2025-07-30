<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Najpierw sprawdźmy proste pobranie destynacji
        try {
            $featuredDestinations = Destination::limit(6)->get()->map(function($destination) {
                return [
                    'id' => $destination->id,
                    'name' => $destination->name,
                    'description' => $destination->description,
                    'price' => $destination->price,
                    'original_price' => $destination->original_price,
                    'type' => $destination->type,
                    'duration' => $destination->duration,
                    'rating' => $destination->rating,
                    'activities' => $this->ensureArray($destination->activities),
                    'highlights' => $this->ensureArray($destination->highlights),
                    'image' => $destination->image,
                    'category' => $destination->category,
                    'region' => $destination->region
                ];
            });

            \Log::info('HomeController: Pobrano destynacji: ' . count($featuredDestinations));
        } catch (\Exception $e) {
            \Log::error('HomeController Error: ' . $e->getMessage());
            $featuredDestinations = collect();
        }

        \Log::info('Pobrano ' . count($featuredDestinations) . ' destynacji');

        // Get destinations by categories for other sections
        $mountainDestinations = Destination::where('active', true)
                                          ->where('category', 'górskie')
                                          ->limit(3)
                                          ->get();

        $coastalDestinations = Destination::where('active', true)
                                        ->where('category', 'nadmorskie')
                                        ->limit(3)
                                        ->get();

        $culturalDestinations = Destination::where('active', true)
                                         ->where('category', 'kulturalne')
                                         ->limit(3)
                                         ->get();

        // Travel types data for the view
        $travelTypes = [
            [
                'name' => 'Wycieczki górskie',
                'description' => 'Odkryj majestyczne szczyty i górskie krajobrazy',
                'icon' => '⛰️',
                'duration' => '2-7 dni',
                'price_from' => 199,
                'popular' => true
            ],
            [
                'name' => 'Nadmorskie wakacje',
                'description' => 'Relaks nad Bałtykiem i Morzem Północnym',
                'icon' => '🏖️',
                'duration' => '3-10 dni',
                'price_from' => 249,
                'popular' => false
            ],
            [
                'name' => 'Wycieczki kulturalne',
                'description' => 'Historia, zabytki i kultura polskich miast',
                'icon' => '🏰',
                'duration' => '1-4 dni',
                'price_from' => 179,
                'popular' => true
            ],
            [
                'name' => 'Przygody outdoor',
                'description' => 'Aktywny wypoczynek na łonie natury',
                'icon' => '🚵',
                'duration' => '1-5 dni',
                'price_from' => 159,
                'popular' => false
            ]
        ];

        // Statistics data for the view
        $stats = [
            [
                'icon' => '👥',
                'value' => 15000,
                'label' => 'Zadowolonych klientów'
            ],
            [
                'icon' => '📍',
                'value' => 250,
                'label' => 'Destynacji'
            ],
            [
                'icon' => '⭐',
                'value' => 4.9,
                'label' => 'Średnia ocena'
            ],
            [
                'icon' => '🎯',
                'value' => 98,
                'label' => '% Rekomendacji'
            ]
        ];

        return view('home', compact(
            'featuredDestinations',
            'mountainDestinations',
            'coastalDestinations',
            'culturalDestinations',
            'travelTypes',
            'stats'
        ));
    }

    /**
     * Helper method to ensure data is an array
     */
    private function ensureArray($data)
    {
        if (is_string($data)) {
            // Try to decode as JSON first
            $decoded = json_decode($data, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }
            // If it's a string that's not JSON, split by commas or return as single element array
            return $data ? explode(',', trim($data)) : [];
        }

        if (is_array($data)) {
            return $data;
        }

        return [];
    }
}
