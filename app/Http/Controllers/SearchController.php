<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('query', '');
        $date = $request->get('date', '');
        $travelers = $request->get('travelers', 1);
        $category = $request->get('category', 'all');
        $priceMin = $request->get('price_min', 0);
        $priceMax = $request->get('price_max', 1000);

        $destinations = $this->getDestinations();

        // Filtruj wyniki
        $results = collect($destinations)->filter(function ($destination) use ($query, $category, $priceMin, $priceMax) {
            $matchesQuery = empty($query) ||
                           stripos($destination['name'], $query) !== false ||
                           stripos($destination['description'], $query) !== false ||
                           collect($destination['activities'])->contains(function ($activity) use ($query) {
                               return stripos($activity, $query) !== false;
                           });

            $matchesCategory = $category === 'all' || $destination['category'] === $category;
            $matchesPrice = $destination['price'] >= $priceMin && $destination['price'] <= $priceMax;

            return $matchesQuery && $matchesCategory && $matchesPrice;
        });

        $categories = [
            'all' => 'Wszystkie',
            'mountains' => 'Góry',
            'seaside' => 'Morze',
            'cultural' => 'Kultura',
            'urban' => 'Miasta',
            'nature' => 'Przyroda'
        ];

        return view('search.results', compact('results', 'query', 'date', 'travelers', 'category', 'categories', 'priceMin', 'priceMax'));
    }

    private function getDestinations()
    {
        return [
            [
                'id' => 1,
                'name' => 'Zakopane',
                'description' => 'Stolica polskich Tatr - góry, kuligi i oscypek',
                'image' => '/images/destinations/zakopane.jpg',
                'price' => 199,
                'original_price' => 249,
                'type' => 'górskie',
                'duration' => '3 dni',
                'rating' => 4.8,
                'activities' => ['Narty/snowboard', 'Wędrówki górskie', 'Kuligi', 'Termy'],
                'highlights' => ['Kasprowy Wierch', 'Morskie Oko', 'Krupówki'],
                'category' => 'mountains'
            ],
            [
                'id' => 2,
                'name' => 'Gdańsk',
                'description' => 'Perła Bałtyku - historia, kultura i morze',
                'image' => '/images/destinations/gdansk.jpg',
                'price' => 249,
                'original_price' => 299,
                'type' => 'nadmorskie',
                'duration' => '4 dni',
                'rating' => 4.9,
                'activities' => ['Plaże', 'Muzea', 'Żuraw portowy', 'Amber Sky Wheel'],
                'highlights' => ['Stare Miasto', 'Westerplatte', 'Sopot'],
                'category' => 'seaside'
            ],
            [
                'id' => 3,
                'name' => 'Kraków',
                'description' => 'Królewskie miasto pełne magii i historii',
                'image' => '/images/destinations/krakow.jpg',
                'price' => 179,
                'original_price' => 219,
                'type' => 'kulturalne',
                'duration' => '3 dni',
                'rating' => 4.9,
                'activities' => ['Wawel', 'Rynek Główny', 'Kazimierz', 'Kopalnia soli'],
                'highlights' => ['Zamek Wawel', 'Sukiennice', 'Wieliczka'],
                'category' => 'cultural'
            ],
            [
                'id' => 4,
                'name' => 'Wrocław',
                'description' => 'Miasto 100 mostów i krasnali',
                'image' => '/images/destinations/wroclaw.jpg',
                'price' => 189,
                'original_price' => 229,
                'type' => 'miejskie',
                'duration' => '2 dni',
                'rating' => 4.7,
                'activities' => ['Krasnale', 'Ostrów Tumski', 'Rynek', 'Fontanna'],
                'highlights' => ['Stary Rynek', 'Panorama Racławicka', 'ZOO'],
                'category' => 'urban'
            ],
            [
                'id' => 5,
                'name' => 'Białowieża',
                'description' => 'Ostatnia pierwotna puszcza Europy',
                'image' => '/images/destinations/bialowieza.jpg',
                'price' => 159,
                'original_price' => 199,
                'type' => 'przyrodnicze',
                'duration' => '2 dni',
                'rating' => 4.6,
                'activities' => ['Safari żubrowe', 'Puszcza', 'Rezerwat', 'Ścieżki przyrodnicze'],
                'highlights' => ['Żubry', 'Park Narodowy', 'Muzeum Przyrody'],
                'category' => 'nature'
            ],
            [
                'id' => 6,
                'name' => 'Karpacz',
                'description' => 'Śnieżka i Wang - góry i architektura',
                'image' => '/images/destinations/karpacz.jpg',
                'price' => 169,
                'original_price' => 209,
                'type' => 'górskie',
                'duration' => '3 dni',
                'rating' => 4.5,
                'activities' => ['Śnieżka', 'Wang', 'Kolejka', 'Muzeum Zabawek'],
                'highlights' => ['Śnieżka', 'Kościół Wang', 'Wodospad Kamieńczyka'],
                'category' => 'mountains'
            ]
        ];
    }
}
