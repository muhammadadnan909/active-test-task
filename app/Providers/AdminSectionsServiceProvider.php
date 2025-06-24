<?php

namespace App\Providers;

use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;
use App\Models\Post;
use App\Admin\Sections\Posts as PostSection;
class AdminSectionsServiceProvider extends ServiceProvider
{

    /**
     * @var array
     */
    protected $sections = [
        //\App\User::class => 'App\Http\Sections\Users',
    ];

    /**
     * Register sections.
     *
     * @param \SleepingOwl\Admin\Admin $admin
     * @return void
     */
    public function boot(\SleepingOwl\Admin\Admin $admin)
    {
    	//
        $admin->registerModel(Post::class, function () {
        return PostSection::class;
    });

        parent::boot($admin);
    }


}
