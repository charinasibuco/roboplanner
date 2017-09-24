<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $data = [
	       [
	       		'parent_id' 	=> '0',
	       		'title'			=> 'First Category',
	       		'slug'			=> 'first-category',
	       		'sort' 			=> '1',
	       		'description' 	=> 'first-category'
	       ],
	       [
	       		'parent_id' 	=> '0',
	       		'title'			=> 'Second Category',
	       		'slug'			=> 'second-category',
	       		'sort' 			=> '2',
	       		'description' 	=> 'second-category'
	       ],
	       [
	       		'parent_id' 	=> '0',
	       		'title'			=> 'Third Category',
	       		'slug'			=> 'third-category',
	       		'sort' 			=> '3',
	       		'description' 	=> 'third-category'
	       ],
	       [
	       		'parent_id' 	=> '0',
	       		'title'			=> 'Fourth Category',
	       		'slug'			=> 'fourth-category',
	       		'sort' 			=> '4',
	       		'description' 	=> 'fourth-category'
	       ],
	       [
	       		'parent_id' 	=> '0',
	       		'title'			=> 'Fifth Category',
	       		'slug'			=> 'fifth-category',
	       		'sort' 			=> '5',
	       		'description' 	=> 'fifth-category'
	       ]
       ];

       $category_posts = [
	       	[
	       		'post_id' 		=> '1',
	       		'category_id' 	=> '1',
	       	],
	       	[
	       		'post_id' 		=> '2',
	       		'category_id' 	=> '2',
	       	],
	       	[
	       		'post_id' 		=> '3',
	       		'category_id' 	=> '3',
	       	],
	       	[
	       		'post_id' 		=> '4',
	       		'category_id' 	=> '4',
	       	],
	       	[
	       		'post_id' 		=> '5',
	       		'category_id' 	=> '5',
	       	]
       ];
       foreach ($data as $key) {
       		DB::table('categories')->insert([
				'title'			=>	$key['title'],
        		'parent_id'		=>  $key['parent_id'], 	
				'slug'			=>	$key['slug'],	
				'sort'			=>	$key['sort'],	
				'description'	=>	$key['description'],	
            ]);
       }
       foreach ($category_posts as $category_post) {
       		DB::table('category_post')->insert([
				'post_id'			=>	$category_post['post_id'],
        		'category_id'		=>  $category_post['category_id'], 		
            ]);
       }
    }
}
