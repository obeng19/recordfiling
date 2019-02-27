<?php

namespace App\Providers;


use App\AuditTrail;
use App\Category;
use App\Eid;
use App\Hospital;
use App\Item;
use App\Region;
use App\Role;
use App\Subcategory;
use App\User;
use App\ViralLoad;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);


        view()->composer('*', function($view)
        {
            $_user = auth()->user();

            if (!empty($_user))
            {
                //dashboard cracks
                $users=User::all()->count();
                $audit=AuditTrail::all()->count();

//                dd($user_VR);


                $_role=$_user->role->code;
                if($_role==='ADM_MAIN'){
                    $roles=Role::query()
                        ->where('code','!=','SYS_ADM')->get();
                }
                else{
                    $roles=Role::all();
                }

                $regions=Region::all();
                $category=Category::all();
                $subcategory=Subcategory::all();
                $permissions=Permission::all();
                //the measurement counts



                $view->with([
                    '_user'     => $_user,
                    '_role'     => $_role,
                    'roles'     => $roles,
                    'regions'     => $regions,
                    'users'     => $users,
                    'audit'     => $audit,
                    'category'     => $category,
                    'subcategory'     => $subcategory,
                    'permissions'     => $permissions,
                ]);
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
