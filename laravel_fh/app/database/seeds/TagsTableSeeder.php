<?php

class TagsTableSeeder extends Seeder {

    public function run()
    {
    	
        $tags = [
            [
                'id'   => '1',
                'name' => 'database',
                'slug' => 'database',
            ],
            [
                'id'   => '2',
                'name' => 'view data',
                'slug' => 'view-data',
            ],
            [
                'id'   => '3',
                'name' => '4.1',
                'slug' => '41',
            ],
        ];

        DB::table('tags')->insert($tags);

        DB::table('tag_trick')->insert([
            [ 'tag_id' => '1', 'trick_id' => '1' ],
            [ 'tag_id' => '2', 'trick_id' => '2' ],
            [ 'tag_id' => '1', 'trick_id' => '3' ],
            [ 'tag_id' => '3', 'trick_id' => '3' ],
        ]);
        
    
    	/*
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
    	*/
    	
    }
}
