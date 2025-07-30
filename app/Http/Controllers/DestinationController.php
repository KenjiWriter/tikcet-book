<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    /**
     * Display a listing of destinations.
     */
    public function index(Request $request)
    {
        $query = Destination::where('active', true);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('region', 'like', "%{$search}%");
            });
        }

        // Region filter
        if ($request->filled('region')) {
            $query->where('region', $request->get('region'));
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->get('category'));
        }

        // Price filter
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->get('price_min'));
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->get('price_max'));
        }

        // Duration filter
        if ($request->filled('duration')) {
            $query->where('duration', $request->get('duration'));
        }

        // Sort by
        $sortBy = $request->get('sort', 'name');
        $sortOrder = $request->get('order', 'asc');

        if (in_array($sortBy, ['name', 'price', 'rating', 'duration'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $destinations = $query->paginate(9);

        // Get filter options for the sidebar
        $regions = Destination::where('active', true)
                              ->distinct()
                              ->pluck('region')
                              ->sort();

        $categories = Destination::where('active', true)
                                 ->distinct()
                                 ->pluck('category')
                                 ->sort();

        return view('destinations.index', compact('destinations', 'regions', 'categories'));
    }

    /**
     * Display the specified destination.
     */
    public function show($id)
    {
        $destinationModel = Destination::where('active', true)->findOrFail($id);

        // Debug the raw data
        \Log::info('Raw destination data:', [
            'highlights' => $destinationModel->highlights,
            'activities' => $destinationModel->activities,
            'included' => $destinationModel->included,
            'not_included' => $destinationModel->not_included
        ]);

        // Convert to array format that the view expects
        $destination = [
            'id' => $destinationModel->id,
            'name' => $destinationModel->name,
            'description' => $destinationModel->description,
            'price' => $destinationModel->price,
            'original_price' => $destinationModel->original_price,
            'type' => $destinationModel->type,
            'duration' => $destinationModel->duration ?: '3 dni',
            'rating' => $destinationModel->rating,
            'activities' => json_decode($destinationModel->activities, true) ?: [],
            'highlights' => json_decode($destinationModel->highlights, true) ?: [],
            'image' => $destinationModel->image,
            'category' => $destinationModel->category,
            'region' => $destinationModel->region,
            'city' => $destinationModel->city,
            'active' => $destinationModel->active,
            'max_people' => 50, // Default value since column doesn't exist
            'min_age' => 0,     // Default value since column doesn't exist
            'included' => is_string($destinationModel->included) ? json_decode($destinationModel->included, true) ?: [] : ($destinationModel->included ?: []),
            'not_included' => is_string($destinationModel->not_included) ? json_decode($destinationModel->not_included, true) ?: [] : ($destinationModel->not_included ?: []),
            'itinerary' => 'Program wycieczki dostępny po rezerwacji.',           // Default value since column doesn't exist
            'what_to_bring' => 'Wygodne buty, ubrania dostosowane do pogody.',   // Default value since column doesn't exist
            'cancellation_policy' => 'Bezpłatne anulowanie do 24h przed rozpoczęciem.' // Default value since column doesn't exist
        ];

        // Debug the processed data
        \Log::info('Processed destination data:', [
            'highlights' => $destination['highlights'],
            'activities' => $destination['activities'],
            'included' => $destination['included'],
            'not_included' => $destination['not_included']
        ]);

        // Get related destinations (same region or category)
        $relatedDestinations = Destination::where('active', true)
                                          ->where('id', '!=', $id)
                                          ->where(function($query) use ($destinationModel) {
                                              $query->where('region', $destinationModel->region)
                                                    ->orWhere('category', $destinationModel->category);
                                          })
                                          ->limit(3)
                                          ->get();

        // Convert related destinations to array format
        $similarDestinations = $relatedDestinations->map(function($dest) {
            return [
                'id' => $dest->id,
                'name' => $dest->name,
                'description' => $dest->description,
                'price' => $dest->price,
                'type' => $dest->type,
                'duration' => $dest->duration ?: '3 dni',
                'rating' => $dest->rating,
                'image' => $dest->image
            ];
        })->toArray();

        return view('destinations.show', compact('destination', 'similarDestinations'));
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
