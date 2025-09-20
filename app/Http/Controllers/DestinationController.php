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
    public function show($name)
    {
        $destinations = [
            'warszawa' => [
                'name' => 'Warszawa',
                'icon' => '🏛️',
                'description' => 'Stolica Polski - nowoczesna metropolia z bogatą historią',
                'rating' => '4.8',
                'distance' => '0 km',
                'population' => '1.8M',
                'temperature' => '15°C',
                'about' => 'Warszawa to dynamiczna stolica Polski, która łączy nowoczesność z tradycją. Miasto pełne jest zabytków, muzeów, parków i nowoczesnych budynków.',
                'history' => 'Założona w XIII wieku, Warszawa stała się stolicą Polski w 1596 roku. Miasto zostało niemal całkowicie zniszczone podczas II wojny światowej, ale zostało odbudowane z dbałością o historyczne detale.',
                'attractions' => [
                    ['icon' => '🏰', 'name' => 'Zamek Królewski', 'description' => 'Historyczna siedziba królów Polski'],
                    ['icon' => '🌳', 'name' => 'Łazienki Królewskie', 'description' => 'Piękny park z pałacem na wodzie'],
                    ['icon' => '🏛️', 'name' => 'Muzeum Powstania Warszawskiego', 'description' => 'Interaktywne muzeum historii'],
                    ['icon' => '🌆', 'name' => 'Pałac Kultury i Nauki', 'description' => 'Symbol Warszawy i najwyższy budynek'],
                    ['icon' => '🎭', 'name' => 'Teatr Wielki', 'description' => 'Narodowa opera i balet']
                ],
                'cuisine' => 'Warszawa oferuje szeroką gamę kuchni - od tradycyjnej polskiej po międzynarodową. Znajdziesz tu zarówno eleganckie restauracje, jak i przytulne kawiarnie.',
                'specialties' => 'Pierogi, żurek, bigos, pączki, sernik warszawski',
                'pricing' => [
                    ['type' => 'Pociąg', 'price' => '45zł', 'details' => 'PKP Intercity'],
                    ['type' => 'Autobus', 'price' => '35zł', 'details' => 'FlixBus'],
                    ['type' => 'Samolot', 'price' => '120zł', 'details' => 'LOT']
                ]
            ],
            'krakow' => [
                'name' => 'Kraków',
                'icon' => '🐉',
                'description' => 'Królewskie miasto - perła polskiej architektury',
                'rating' => '4.9',
                'distance' => '300 km',
                'population' => '780k',
                'temperature' => '14°C',
                'about' => 'Kraków to jedno z najpiękniejszych miast Polski, pełne zabytków, legend i magicznej atmosfery. Była stolica Polski zachwyca swoją architekturą.',
                'history' => 'Kraków był stolicą Polski przez ponad 500 lat. Miasto uniknęło zniszczeń podczas II wojny światowej, dzięki czemu zachowało swój średniowieczny charakter.',
                'attractions' => [
                    ['icon' => '🏰', 'name' => 'Wawel', 'description' => 'Zamek królewski i katedra'],
                    ['icon' => '🏛️', 'name' => 'Rynek Główny', 'description' => 'Największy średniowieczny rynek w Europie'],
                    ['icon' => '⛪', 'name' => 'Kościół Mariacki', 'description' => 'Słynny kościół z hejnałem'],
                    ['icon' => '🏛️', 'name' => 'Sukiennice', 'description' => 'Historyczne hale targowe'],
                    ['icon' => '🌳', 'name' => 'Planty', 'description' => 'Park wokół Starego Miasta']
                ],
                'cuisine' => 'Kraków słynie z tradycyjnej kuchni polskiej. Znajdziesz tu autentyczne pierogi, żurek, bigos i inne regionalne specjały.',
                'specialties' => 'Obwarzanek krakowski, maczanka krakowska, kremówka papieska',
                'pricing' => [
                    ['type' => 'Pociąg', 'price' => '45zł', 'details' => 'PKP Intercity'],
                    ['type' => 'Autobus', 'price' => '35zł', 'details' => 'FlixBus'],
                    ['type' => 'Samolot', 'price' => '150zł', 'details' => 'LOT']
                ]
            ],
            'gdansk' => [
                'name' => 'Gdańsk',
                'icon' => '⚓',
                'description' => 'Nadmorska perła - miasto bursztynu i historii',
                'rating' => '4.7',
                'distance' => '340 km',
                'population' => '470k',
                'temperature' => '12°C',
                'about' => 'Gdańsk to piękne nadmorskie miasto z bogatą historią hanzeatycką. Miasto bursztynu i Solidarności zachwyca swoją architekturą i atmosferą.',
                'history' => 'Gdańsk ma ponad 1000-letnią historię. Był ważnym miastem hanzeatyckim i miejscem wybuchu II wojny światowej oraz narodzin Solidarności.',
                'attractions' => [
                    ['icon' => '🏛️', 'name' => 'Długi Targ', 'description' => 'Główna ulica Starego Miasta'],
                    ['icon' => '⚓', 'name' => 'Żuraw', 'description' => 'Symbol Gdańska - średniowieczny dźwig'],
                    ['icon' => '🏛️', 'name' => 'Ratusz Głównego Miasta', 'description' => 'Piękny ratusz z wieżą'],
                    ['icon' => '⛪', 'name' => 'Bazylika Mariacka', 'description' => 'Największy ceglany kościół na świecie'],
                    ['icon' => '🏭', 'name' => 'Stocznia Gdańska', 'description' => 'Miejsce narodzin Solidarności']
                ],
                'cuisine' => 'Gdańsk oferuje wyśmienitą kuchnię z akcentem na ryby i owoce morza. Znajdziesz tu tradycyjne dania pomorskie.',
                'specialties' => 'Ryba po gdańsku, pierogi z rybą, flaki gdańskie, bursztyn',
                'pricing' => [
                    ['type' => 'Pociąg', 'price' => '55zł', 'details' => 'PKP Intercity'],
                    ['type' => 'Autobus', 'price' => '40zł', 'details' => 'FlixBus'],
                    ['type' => 'Samolot', 'price' => '180zł', 'details' => 'LOT']
                ]
            ],
            'wroclaw' => [
                'name' => 'Wrocław',
                'icon' => '🧚',
                'description' => 'Miasto krasnali - wrocławska magia',
                'rating' => '4.6',
                'distance' => '350 km',
                'population' => '640k',
                'temperature' => '13°C',
                'about' => 'Wrocław to urocze miasto na 12 wyspach, połączonych ponad 100 mostami. Miasto krasnali zachwyca swoją architekturą i atmosferą.',
                'history' => 'Wrocław ma bogatą historię sięgającą X wieku. Był stolicą Śląska i ważnym ośrodkiem handlowym. Po II wojnie światowej został włączony do Polski.',
                'attractions' => [
                    ['icon' => '🏛️', 'name' => 'Rynek', 'description' => 'Piękny rynek z ratuszem'],
                    ['icon' => '🧚', 'name' => 'Krasnale', 'description' => 'Ponad 600 krasnali w całym mieście'],
                    ['icon' => '⛪', 'name' => 'Katedra św. Jana', 'description' => 'Gotycka katedra na Ostrowie Tumskim'],
                    ['icon' => '🌳', 'name' => 'Ogród Japoński', 'description' => 'Piękny ogród w stylu japońskim'],
                    ['icon' => '🏛️', 'name' => 'Hala Stulecia', 'description' => 'UNESCO - modernistyczna hala']
                ],
                'cuisine' => 'Wrocław oferuje różnorodną kuchnię z wpływami śląskimi, niemieckimi i polskimi. Znajdziesz tu wyśmienite restauracje i kawiarnie.',
                'specialties' => 'Kiełbasa śląska, kluski śląskie, makówki, wrocławskie pierogi',
                'pricing' => [
                    ['type' => 'Pociąg', 'price' => '50zł', 'details' => 'PKP Intercity'],
                    ['type' => 'Autobus', 'price' => '38zł', 'details' => 'FlixBus'],
                    ['type' => 'Samolot', 'price' => '160zł', 'details' => 'LOT']
                ]
            ]
        ];

        $destination = $destinations[$name] ?? null;
        
        if (!$destination) {
            abort(404, 'Destynacja nie została znaleziona');
        }

        return view('destinations.show', compact('destination'));
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
