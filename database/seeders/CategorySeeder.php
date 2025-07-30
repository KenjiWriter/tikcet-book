<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Góry',
                'slug' => 'mountains',
                'description' => 'Górskie przygody i alpejskie krajobrazy',
                'icon' => '🏔️',
                'color' => '#10b981'
            ],
            [
                'name' => 'Kultura',
                'slug' => 'culture',
                'description' => 'Zabytki, muzea i dziedzictwo kulturowe',
                'icon' => '🏛️',
                'color' => '#8b5cf6'
            ],
            [
                'name' => 'Natura',
                'slug' => 'nature',
                'description' => 'Parki narodowe i rezerwaty przyrody',
                'icon' => '🌲',
                'color' => '#059669'
            ],
            [
                'name' => 'Miasto',
                'slug' => 'urban',
                'description' => 'Miejskie atrakcje i nowoczesne miasta',
                'icon' => '🏙️',
                'color' => '#3b82f6'
            ],
            [
                'name' => 'Morze',
                'slug' => 'sea',
                'description' => 'Wybrzeże, plaże i nadmorskie kurorty',
                'icon' => '🌊',
                'color' => '#06b6d4'
            ],
            [
                'name' => 'Wellness',
                'slug' => 'wellness',
                'description' => 'Uzdrowiska, spa i relaks',
                'icon' => '🧘',
                'color' => '#ec4899'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
