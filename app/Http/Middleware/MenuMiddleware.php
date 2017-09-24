<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Menu;
use Auth;
use App\Page;
class MenuMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {



        Menu::make('AdminMenu', function($menu) use ($request){
                
            if (Auth::check()) {
                $menu->add('Dashboard', ['route' => 'dashboard']);
                if(Auth::user()->hasRole('client')) {
                    $menu->add('Profile', ['route' => 'user_show']);
                }
                if (Auth::user()->can('view_pages')) {
                    $menu->add('Pages', ['route' => 'page']);
                    if($request->segment(2) == 'page'){
                        $menu->pages->attr(['class' => 'active']);
                    }
                }

                if(Auth::user()->can('view_categories')){
                    $menu->add('Categories', ['route' => 'category_list']);
                    if($request->segment(2) == 'categories'){
                        $menu->categories->attr(['class' => 'active']);
                    }
                }

                if (Auth::user()->can('view_blogs')) {
                    $menu->add('Post', ['route' => 'post']);
                    if($request->segment(2) == 'post'){
                        $menu->post->attr(['class' => 'active']);
                    }
                }

                if (Auth::user()->can('view_clients')) {
                    $menu->add('Clients', ['route' => 'clients']);
                    if($request->segment(2) == 'clients'){
                        $menu->clients->attr(['class' => 'active']);
                    }
                }

                if (Auth::user()->can('manage_flags')) {
                    $menu->add('Flags', ['route' => 'flags']);
                    if($request->segment(2) == 'flags'){
                        $menu->flags->attr(['class' => 'active']);
                    }
                }

                if (Auth::user()->can('view_taxes')) {
                    $menu->add('Taxes', ['route' => 'taxes']);
                    if($request->segment(2) == 'taxes'){
                        $menu->taxes->attr(['class' => 'active']);
                    }
                }

                if (Auth::user()->can('view_users')) {
                    $menu->add('Users', ['route' => 'users']);
                    if($request->segment(2) == 'users'){
                        $menu->users->attr(['class' => 'active']);
                    }
                }

                if (Auth::user()->can('view_roles')) {
                    $menu->add('Roles', ['route' => 'role_list']);
                    if($request->segment(2) == 'roles'){
                        $menu->roles->attr(['class' => 'active']);
                    }
                }

                if (Auth::user()->can('view_permissions')) {
                    $menu->add('Permissions', ['route' => 'permission_list']);
                    if($request->segment(2) == 'permissions'){
                        $menu->permissions->attr(['class' => 'active']);
                    }
                }

                if (Auth::user()->can('view_permissions')) {
                    $menu->add('Values', ['route' => 'value_list']);
                    if($request->segment(2) == 'values'){
                        $menu->values->attr(['class' => 'active']);
                    }
                }



                if(Auth::user()->can('view_logs')){
                    $menu->add('Logs', ['route' => 'logs']);
                    if($request->segment(2) == 'logs'){
                        $menu->logs->attr(['class' => 'active']);
                    }
                }

//                $menu->add('Logout', ['route' => 'logout']);

            }
        });

        Menu::make('TopMenu', function($menu) use ($request){
            if (Auth::check()) {
                $menu->add('Dashboard', ['route' => 'dashboard']);
                if (Auth::user()->can('view_clients')) {
                    $menu->add('Clients', ['route' => 'clients']);
                    if($request->segment(2) == 'clients'){
                        $menu->clients->attr(['class' => 'active']);
                    }

                }


                $menu->add('Settings', ['url' => 'javascript:;', 'class' => 'dropdown']);

                    if (Auth::user()->can('view_users')) {
                        $menu->settings->add('Users', ['route' => 'users']);
                    }

                    if (Auth::user()->can('view_roles')) {
                        $menu->settings->add('Roles', ['route' => 'role_list']);
                    }
                    if (Auth::user()->can('view_permissions')) {
                        $menu->settings->add('Permissions', ['route' => 'permission_list']);
                    }
                    if(Auth::user()->can('view_logs')){
                        $menu->settings->add('Logs', ['route' => ['user_logs', Auth::user()->id]]);
                    }
                    $menu->settings->add('Profile', ['route' => 'user_show'])->divide( ['class' => 'divider', 'role' => 'presentation']);
                    $menu->settings->add('Logout', ['route' => 'logout']);
            }
        });


        Menu::make('FrontMenu', function($menu) use ($request){
            $pages_main = Page::get();
            $pages_head = Page::where('parent_id',0)->get();
            $count      = count($pages_head);
            foreach ($pages_main as $page_main) {
                if(($page_main->parent_id) == 0){
                $order = $page_main->order;
                    if($page_main->status == 'hidden'){
                           Page::where('parent_id',$page_main->id)->update(array('status' => 'hidden')); 
                           $menu->add($page_main->title, $page_main->slug)->data(array('order' => $page_main->order, 'class' => 'hidden'));
                        }
                    else{
                        $menu->add($page_main->title, $page_main->slug)->data(array('order' => $page_main->order));
                    }
                }       
                else{
                    $get_title = Page::select('title')->where('id',$page_main->parent_id)->get();
                    foreach ($get_title as $s) {
                        $title = $s->title;
                    }
                    $parent = lcfirst(preg_replace('/\s+/', '',(ucwords($title))));
                    if($page_main->status == 'published')
                    {
                        $menu->$parent->add($page_main->title, $page_main->slug)->data('order', $page_main->order); 
                    }
                    else{
                        Page::where('parent_id',$page_main->id)->update(array('status' => 'hidden')); 
                        $menu->add($page_main->title, $page_main->slug)->data(array('order' => $page_main->order, 'class' => 'hidden'));
                    }

                }  
            }
            if (Auth::check()) {
                $menu->add('My Account', ['route' => 'dashboard'])->data('order', $count+2);
            }else{

                $menu->add('Login', ['route' => 'login'])->data('order', $count+1);
                $menu->add('Signup', ['route' => 'signup'])->data('order', $count+2);
            }
        })->sortBy('order');

        Menu::make('FooterMenu', function($menu) use ($request){
            $pages_main = Page::get();
            foreach ($pages_main as $page_main) {
                if(($page_main->parent_id) == 0){
                $order = $page_main->order;
                    if($page_main->status == 'hidden'){
                           Page::where('parent_id',$page_main->id)->update(array('status' => 'hidden')); 
                           $menu->add($page_main->title, $page_main->slug)->data(array('order' => $page_main->order, 'class' => 'hidden'));
                        }
                    else{
                        $menu->add($page_main->title, $page_main->slug)->data(array('order' => $page_main->order));
                    }
                }       
                else{
                    $get_title = Page::select('title')->where('id',$page_main->parent_id)->get();
                    foreach ($get_title as $s) {
                        $title = $s->title;
                    }
                    $parent = lcfirst(preg_replace('/\s+/', '',(ucwords($title))));
                    if($page_main->status == 'published')
                    {
                        $menu->$parent->add($page_main->title, $page_main->slug)->data('order', $page_main->order);
                    }
                    else{
                       Page::where('parent_id',$page_main->id)->update(array('status' => 'hidden'));
                       $menu->add($page_main->title, $page_main->slug)->data(array('order' => $page_main->order, 'class' => 'hidden'));
                    }
                }  
            }
        })->sortBy('order');
        return $next($request);
    }
}
