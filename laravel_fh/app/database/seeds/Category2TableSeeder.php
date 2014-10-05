<?php

class Category2TableSeeder extends Seeder {

    public function run()
    {
        $categories = [
            [
                'id'          => '1',
                'name'        => 'Views',
                'slug'        => 'views',
                'description' => 'All tricks related to the View class, e.g. View Composers.',
            ],
            [
                'id'          => '2',
                'name'        => 'Eloquent',
                'slug'        => 'eloquent',
                'description' => 'Eloquent ORM',
            ],
        ];

        DB::table('category2')->insert($categories);
        DB::table('category2_product')->insert([
            [ 'category2_id' => '2', 'product_id' => '1' ],
            [ 'category2_id' => '1', 'product_id' => '2' ],
            [ 'category2_id' => '2', 'product_id' => '3' ]
        ]);
    }
}


