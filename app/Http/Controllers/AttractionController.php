<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttractionController extends Controller
{
    public function index()
    {
        $attractions = [
            [
                'id' => 1,
                'name' => 'Zamek Wawel',
                'description' => 'Królewska siedziba na wzgórzu',
                'image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=300&fit=crop',
                'price' => 25,
                'city' => 'Kraków',
                'type' => 'zabytki',
                'rating' => 4.8
            ],
            [
                'id' => 2,
                'name' => 'Żuraw Gdański',
                'description' => 'Średniowieczny dźwig portowy',
                'image' => 'https://images.unsplash.com/photo-1528894975491-4a4e43c4d6b8?w=400&h=300&fit=crop',
                'price' => 15,
                'city' => 'Gdańsk',
                'type' => 'technika',
                'rating' => 4.6
            ],
            [
                'id' => 3,
                'name' => 'Wieliczka Kopalnia Soli',
                'description' => 'Podziemne miasto w soli',
                'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=300&fit=crop',
                'price' => 89,
                'city' => 'Wieliczka',
                'type' => 'natura',
                'rating' => 4.9
            ],
            [
                'id' => 4,
                'name' => 'Malbork',
                'description' => 'Największy ceglany zamek świata',
                'image' => 'https://images.unsplash.com/photo-1551524164-687a55dd1126?w=400&h=300&fit=crop',
                'price' => 35,
                'city' => 'Malbork',
                'type' => 'zabytki',
                'rating' => 4.7
            ],
            [
                'id' => 5,
                'name' => 'Energylandia',
                'description' => 'Największy park rozrywki w Polsce',
                'image' => 'https://images.unsplash.com/photo-1544650937-5dd4f2c1d3db?w=400&h=300&fit=crop',
                'price' => 159,
                'city' => 'Zator',
                'type' => 'rozrywka',
                'rating' => 4.5
            ],
            [
                'id' => 6,
                'name' => 'Aquapark Sopot',
                'description' => 'Relaks nad morzem',
                'image' => 'https://images.unsplash.com/photo-1571902943202-507ec2618e8f?w=400&h=300&fit=crop',
                'price' => 45,
                'city' => 'Sopot',
                'type' => 'relaks',
                'rating' => 4.3
            ]
        ];

        return view('attractions.index', compact('attractions'));
    }

    public function show($id)
    {
        $attractions = $this->getAllAttractions();
        $attraction = collect($attractions)->firstWhere('id', (int)$id);

        if (!$attraction) {
            abort(404);
        }

        return view('attractions.show', compact('attraction'));
    }

    private function getAllAttractions()
    {
        return [
            [
                'id' => 1,
                'name' => 'Zamek Wawel',
                'description' => 'Królewska siedziba na wzgórzu',
                'long_description' => 'Zamek Wawel to jeden z najważniejszych zabytków Polski, będący przez wieki siedzibą królów polskich. Kompleks składa się z zamku królewskiego, katedry oraz licznych muzeów prezentujących bogate zbiory sztuki.',
                'image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=800&h=600&fit=crop',
                'price' => 25,
                'city' => 'Kraków',
                'type' => 'zabytki',
                'rating' => 4.8,
                'duration' => '3-4 godziny',
                'opening_hours' => '9:00 - 17:00',
                'attractions' => ['Komnaty Królewskie', 'Skarbiec', 'Katedra', 'Smocza Jama'],
                'gallery' => [
                    'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop'
                ]
            ]
        ];
    }
}
