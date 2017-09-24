<?php

use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'view_categories',
                'label' => 'Able to view categories'
            ]
            ,[
                'name' => 'add_category',
                'label' => 'Able to add a category'
            ]
            ,
            [
                'name' => 'update_category',
                'label' => 'Able to update a category'
            ]
            ,
            [
                'name' => 'delete_category',
                'label' => 'Able to delete a category'
            ]
            ,
            [
                'name' => 'assign_category',
                'label' => 'Assign a category to a blog'
            ],

            [
                'name' => 'view_blogs',
                'label' => 'Able to view blogs'
            ]
            ,
            [
                'name' => 'add_blog',
                'label' => 'Able to add a blog'
            ]
            ,
            [
                'name' => 'update_blog',
                'label' => 'Able to update a blog'
            ]
            ,
            [
                'name' => 'delete_blog',
                'label' => 'Able to delete a blog'
            ]
        ];

        DB::table('permissions')->insert( $permissions);

        $permission_role = [];

        /** roles for administrator **/
        foreach($permissions as $row){
            $permission_role[] =  [
                'role_id' => DB::table('roles')->where('name','administrator')->first()->id,
                'permission_id' => DB::table('permissions')->where('name',$row['name'])->first()->id
            ];

        }

        DB::table('permission_role')->insert( $permission_role);

    }
}
