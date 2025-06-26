<?php
namespace App\Providers;

use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as BaseAdminSectionsServiceProvider;
use App\Models\Post;
use App\Admin\Sections\Posts;
class AdminServiceProvider extends BaseAdminSectionsServiceProvider
{
    protected function getSections(): array
    {
        return [
            Post::class => Posts::class,
        ];
    }


}
