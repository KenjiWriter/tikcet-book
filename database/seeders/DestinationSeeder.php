<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Destination;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinations = [
            [
                'name' => 'Zakopane',
                'description' => 'Stolica polskich Tatr - góry, kuligi i oscypek',
                'long_description' => 'Zakopane to prawdziwa perła polskich gór, położona u stóp majestykatycznych Tatr. To miejsce, gdzie tradycja góralska spotyka się z nowoczesnym turystyką. Spaceruj po Krupówkach, jednej z najsłynniejszych polskich ulic turystycznych, skosztuj regionalnych przysmaków jak oscypek i żurek góralski, a wieczorem relaksuj się w jednej z licznych restauracji z widokiem na góry.',
                'image' => '/images/destinations/zakopane-main.svg',
                'price' => 199.00,
                'original_price' => 249.00,
                'type' => 'Weekend',
                'duration' => '3 dni',
                'rating' => 4.8,
                'activities' => json_encode(['Narty/snowboard', 'Wędrówki górskie', 'Kuligi']),
                'highlights' => json_encode(['Kasprowy Wierch', 'Morskie Oko', 'Krupówki']),
                'category' => 'górskie',
                'difficulty' => 'średni',
                'season' => 'cały rok',
                'gallery' => json_encode([
                    '/images/destinations/zakopane-1.jpg',
                    '/images/destinations/zakopane-2.jpg',
                    '/images/destinations/zakopane-3.jpg',
                    '/images/destinations/zakopane-4.jpg'
                ]),
                'included' => json_encode(['Noclegi', 'Śniadania', 'Przewodnik', 'Bilety kolejka']),
                'not_included' => json_encode(['Obiady', 'Kolacje', 'Napoje']),
                'city' => 'Zakopane',
                'region' => 'Małopolska',
                'active' => true,
            ],
            [
                'name' => 'Gdańsk',
                'description' => 'Perła Bałtyku - historia, kultura i morze',
                'long_description' => 'Gdańsk to miasto o tysiącletniej historii, które zachwyca swoją architekturą, kulturą i nadmorskim klimatem. Spaceruj po Głównym Mieście z jego kolorowymi kamieniczkami, odwiedź Muzeum II Wojny Światowej, a wieczorem wybierz się na romantyczny spacer po Molo w Sopocie.',
                'image' => '/images/destinations/gdansk-main.svg',
                'price' => 249.00,
                'original_price' => 299.00,
                'type' => 'City Break',
                'duration' => '4 dni',
                'rating' => 4.9,
                'activities' => json_encode(['Plaże', 'Muzea', 'Żuraw portowy']),
                'highlights' => json_encode(['Stare Miasto', 'Westerplatte', 'Sopot']),
                'category' => 'nadmorskie',
                'difficulty' => 'łatwy',
                'season' => 'maj-wrzesień',
                'gallery' => json_encode([
                    '/images/destinations/gdansk-1.jpg',
                    '/images/destinations/gdansk-2.jpg',
                    '/images/destinations/gdansk-3.jpg',
                    '/images/destinations/gdansk-4.jpg'
                ]),
                'included' => json_encode(['Noclegi', 'Śniadania', 'Przewodnik miejski', 'Bilety do muzeów']),
                'not_included' => json_encode(['Obiady', 'Kolacje', 'Transport lokalny']),
                'city' => 'Gdańsk',
                'region' => 'Pomorska',
                'active' => true,
            ],
            [
                'name' => 'Kraków',
                'description' => 'Królewskie miasto pełne magii i historii',
                'long_description' => 'Kraków to dawna stolica Polski, miasto królów i legend. Odkryj tajemnice Wawelu, spaceruj po największym średniowiecznym rynku w Europie, odwiedź żydowską dzielnicę Kazimierz i zanurz się w historii w Muzeum Fabryki Schindlera.',
                'image' => '/images/destinations/krakow-main.svg',
                'price' => 179.00,
                'original_price' => 219.00,
                'type' => 'Weekend',
                'duration' => '3 dni',
                'rating' => 4.9,
                'activities' => json_encode(['Wawel', 'Rynek Główny', 'Kazimierz']),
                'highlights' => json_encode(['Zamek Wawel', 'Sukiennice', 'Wieliczka']),
                'category' => 'kulturalne',
                'difficulty' => 'łatwy',
                'season' => 'cały rok',
                'gallery' => json_encode([
                    '/images/destinations/krakow-1.jpg',
                    '/images/destinations/krakow-2.jpg',
                    '/images/destinations/krakow-3.jpg',
                    '/images/destinations/krakow-4.jpg'
                ]),
                'included' => json_encode(['Noclegi', 'Śniadania', 'Przewodnik', 'Bilety Wawel']),
                'not_included' => json_encode(['Obiady', 'Kolacje', 'Wieliczka']),
                'city' => 'Kraków',
                'region' => 'Małopolska',
                'active' => true,
            ],
            [
                'name' => 'Wrocław',
                'description' => 'Miasto stu mostów i krasnali',
                'long_description' => 'Wrocław to jedno z najpiękniejszych miast Polski, nazywane Wenecją Północy ze względu na liczne kanały i mosty. Odkryj colorowy Rynek z gotyckim ratuszem, poszukaj krasnali ukrytych w całym mieście i odwiedź malowniczą Ostrów Tumski.',
                'image' => '/images/destinations/wroclaw-main.svg',
                'price' => 189.00,
                'original_price' => 229.00,
                'type' => 'Weekend',
                'duration' => '3 dni',
                'rating' => 4.7,
                'activities' => json_encode(['Narty/snowboard', 'Wędrówki górskie', 'Kultigi']),
                'highlights' => json_encode(['Rynek', 'Ostrów Tumski', 'Krasnale']),
                'category' => 'miejskie',
                'difficulty' => 'łatwy',
                'season' => 'cały rok',
                'gallery' => json_encode([
                    '/images/destinations/wroclaw-1.jpg',
                    '/images/destinations/wroclaw-2.jpg',
                    '/images/destinations/wroclaw-3.jpg',
                    '/images/destinations/wroclaw-4.jpg'
                ]),
                'included' => json_encode(['Noclegi', 'Śniadania', 'Przewodnik', 'Mapa krasnali']),
                'not_included' => json_encode(['Obiady', 'Kolacje', 'Transport']),
                'city' => 'Wrocław',
                'region' => 'Dolnośląska',
                'active' => true,
            ],
            [
                'name' => 'Poznań',
                'description' => 'Kolebka polskiej państwowości',
                'long_description' => 'Poznań to miasto o bogatej historii, gdzie rozpoczęła się polska państwowość. Odwiedź Stary Rynek z renesansowym ratuszem, zobacz słynne koziołki poznańskie, a także odkryj nowoczesną stronę miasta na Starym Browarze.',
                'image' => '/images/destinations/poznan-main.svg',
                'price' => 159.00,
                'original_price' => 199.00,
                'type' => 'City Break',
                'duration' => '2 dni',
                'rating' => 4.6,
                'activities' => json_encode(['Stary Rynek', 'Ostrów Tumski', 'Stary Browar']),
                'highlights' => json_encode(['Ratusz', 'Koziołki', 'Katedra']),
                'category' => 'miejskie',
                'difficulty' => 'łatwy',
                'season' => 'cały rok',
                'gallery' => json_encode([
                    '/images/destinations/poznan-1.jpg',
                    '/images/destinations/poznan-2.jpg',
                    '/images/destinations/poznan-3.jpg',
                    '/images/destinations/poznan-4.jpg'
                ]),
                'included' => json_encode(['Noclegi', 'Śniadania', 'Przewodnik']),
                'not_included' => json_encode(['Obiady', 'Kolacje', 'Bilety muzea']),
                'city' => 'Poznań',
                'region' => 'Wielkopolska',
                'active' => true,
            ],
            [
                'name' => 'Karpacz',
                'description' => 'Perła Karkonoszy z widokiem na Śnieżkę',
                'long_description' => 'Karpacz to malownicze miasteczko u stóp Śnieżki, najwyższego szczytu Karkonoszy. To idealne miejsce dla miłośników gór, oferujące świetne warunki do narciarstwa zimą i pieszych wędrówek latem. Odwiedź Wang - drewniany kościół z XII wieku i podziwiaj panoramę z Małej Kopy.',
                'image' => '/images/destinations/karpacz-main.svg',
                'price' => 169.00,
                'original_price' => 209.00,
                'type' => 'Outdoor',
                'duration' => '3 dni',
                'rating' => 4.5,
                'activities' => json_encode(['Narciarstwo', 'Hiking', 'Kolej linowa']),
                'highlights' => json_encode(['Śnieżka', 'Wang', 'Mała Kopa']),
                'category' => 'górskie',
                'difficulty' => 'średni',
                'season' => 'cały rok',
                'gallery' => json_encode([
                    '/images/destinations/karpacz-1.jpg',
                    '/images/destinations/karpacz-2.jpg',
                    '/images/destinations/karpacz-3.jpg',
                    '/images/destinations/karpacz-4.jpg'
                ]),
                'included' => json_encode(['Noclegi', 'Śniadania', 'Bilety kolejka', 'Mapa szlaków']),
                'not_included' => json_encode(['Obiady', 'Karnety narciarskie', 'Wypożyczalnia sprzętu']),
                'city' => 'Karpacz',
                'region' => 'Dolnośląska',
                'active' => true,
            ]
        ];

        foreach ($destinations as $destinationData) {
            Destination::create($destinationData);
        }
    }
}
