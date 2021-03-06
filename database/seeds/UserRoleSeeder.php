<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;
//use App\Permission;
//use App\Role;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::table('roles')->insert( [
            'name' => 'administrator',
            'label' => 'manages activities within the workspace'
        ]);

        DB::table('roles')->insert([
            'name' => 'client',
            'label' => 'client; has access only/his or her account'
        ]);

        //\App\User::orderBy('created_at','desc')->first()->assignRole('administrator');

       $permissions = [
                [
                    'name' => 'view_users',
                    'label' => 'Able to view users'
                ]
                ,[
                    'name' => 'add_user',
                    'label' => 'Able to add a user'
                ]
                ,
                [
                    'name' => 'update_user',
                    'label' => 'Able to update a user'
                ]
                ,
                [
                    'name' => 'update_account',
                    'label' => 'Able to update own account'
                ],
                [
                    'name' => 'delete_user',
                    'label' => 'Able to delete a user'
                ]
                ,
                [
                    'name' => 'view_roles',
                    'label' => 'Able to view roles'
                ],
                [
                    'name' => 'add_role',
                    'label' => 'Able to add a role'
                ]
                ,
                [
                    'name' => 'update_role',
                    'label' => 'Able to update a role'
                ]
                ,
                [
                    'name' => 'delete_role',
                    'label' => 'Able to delete a role'
                ]
                ,
                [
                    'name' => 'view_permissions',
                    'label' => 'Able to view permissions'
                ]
                ,[
                    'name' => 'add_permission',
                    'label' => 'Able to add a permission'
                ]
                ,
                [
                    'name' => 'update_permission',
                    'label' => 'Able to update a permission'
                ]
                ,
                [
                    'name' => 'delete_permission',
                    'label' => 'Able to delete a permission'
                ]
                ,
               [
                   'name' => 'assign_role',
                   'label' => 'Assign a role to a user'
               ]
               ,
               [
                   'name' => 'change_role',
                   'label' => "change a user's role"
                ]
               ,
               [
                   'name' => 'view_logs',
                   'label' => "Users able to show all logs"
               ]
                ,
               [
                   'name' => 'view_user_logs',
                   'label' => "Users able to view logs per users"
               ],
               [
                   'name' => 'view_clients',
                   'label' => "Users able to view Clients"
               ],
               [
                   'name' => 'view_client_profile',
                   'label' => "Users able to view Clients Profile"
               ],
               [
                   'name' => 'edit_client',
                   'label' => "Users able to edit Clients"
               ],
               [
                   'name' => 'delete_client',
                   'label' => "Users able to delete Clients"
               ],
               [
                   'name' => 'manage_flags',
                   'label' => "Users able to manage flags"
               ],
               [
                   'name' => 'view_pages',
                   'label' => "Users able to view page"
               ],
               [
                   'name' => 'add_page',
                   'label' => "Users able to add page"
               ],
               [
                   'name' => 'edit_page',
                   'label' => "Users able to update page"
               ],
               [
                   'name' => 'delete_page',
                   'label' => "Users able to delete page"
               ],
               [
                   'name' => 'view_taxes',
                   'label' => "Users able to view taxes"
               ],
               [
                   'name' => 'create_tax',
                   'label' => "Users able to add taxes"
               ],
               [
                   'name' => 'edit_tax',
                   'label' => "Users able to update taxes"
               ],
               [
                   'name' => 'delete_tax',
                   'label' => "Users able to delete taxes"
               ],
               [
                   'name' => 'view_posts',
                   'label' => "Users able to view posts"
               ],
               [
                   'name' => 'add_posts',
                   'label' => "Users able to add posts"
               ],
               [
                   'name' => 'edit_posts',
                   'label' => "Users able to update posts"
               ],
               [
                   'name' => 'delete_posts',
                   'label' => "Users able to delete posts"
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

        /** roles for employee **/
        $permission_role[] =  [
            'role_id' => DB::table('roles')->where('name','client')->first()->id,
            'permission_id' => DB::table('permissions')->where('name','update_account')->first()->id
        ];

        DB::table('permission_role')->insert( $permission_role);

        $role_user = [
        	['role_id' => '1', 'user_id' => '1'],
        	['role_id' => '2', 'user_id' => '2']
        ];

        DB::table('role_user')->insert( $role_user);


    }
}
