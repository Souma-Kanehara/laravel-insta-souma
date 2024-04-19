<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\MOdels\Category; // represents categories table

class CategorySeeder extends Seeder
{

    private $category;

    public function __construct(Category $category){
        $this->category = $category;
    }

    public function run(): void
    {
        /**
        * Games,Books,Programing,Mysql
        */
        $categories = [
            [
                'name' => 'TestCategory3',
                'created_at' => now(), // date & time
                'updated_at' => now()
            ],
            [
                'name' => 'TestCategory4',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // [
            //     'name' => 'Programing',
            //     'created_at' => now(),
            //     'updated_at' => now()
            // ],
            // [
            //     'name' => 'MySql',
            //     'created_at' => now(),
            //     'updated_at' => now()
            // ]

            ];

            $this->category->insert($categories);
    }
}

// php artisan migrate and php artisan db:seed
