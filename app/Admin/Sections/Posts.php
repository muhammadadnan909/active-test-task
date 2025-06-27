<?php
namespace App\Admin\Sections;

use KodiComponents\Support\Contracts\Initializable;
use SleepingOwl\Admin\Section;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Display\DisplayDatatablesAsync;
use SleepingOwl\Admin\Display\Column\Text;
use App\Models\Post;
use SleepingOwl\Admin\Display\Column\Datetime;
use SleepingOwl\Admin\Facades\Display as AdminDisplay;
use SleepingOwl\Admin\Facades\TableColumn as AdminColumn;

use SleepingOwl\Admin\Form\Buttons\FormButtons;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Delete;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Display\Column\Custom;
use SleepingOwl\Admin\Display\Extension\Actions;
use SleepingOwl\Admin\Display\Extension\InitExtensions;
use Illuminate\Support\Facades\Session;


use SleepingOwl\Admin\Admin;

class Posts extends Section implements Initializable
{

    protected $model = Post::class;
    protected $title = 'Posts';

    public function __construct(\Illuminate\Contracts\Foundation\Application $app, $class)
{
    parent::__construct($app, $class);
    $this->initialize(); // Force initialization
}

     public function initialize()
    {
        // v8.x specific initialization
    }



    public function onDisplay(): DisplayInterface
    {

        $display =AdminDisplay::datatablesAsync()
            ->setName('posts')
            ->setHtmlAttributes(['class' => 'table table-bordered'])
            ->setDisplaySearch(true)
            ->setDisplayLength(true)
            ->with(['user', 'admin'])
            ->setColumns([
                AdminColumn::text('id', 'ID')
                    ->setHtmlAttribute('style', 'min-width: 100%; max-width: 70px;overflow: hidden; text-overflow: ellipsis; white-space: nowrap;')
                    ->setHtmlAttribute('class', 'text-center'),

              AdminColumn::custom('Username', function ($model) {
                        if ($model->role === 'admin' && $model->admin) {
                                return $model->admin->full_name ?? 'No Name';
                            }

                            if ($model->role === 'user' && $model->user) {
                                return $model->user->full_name ?? 'No Name';
                            }


                return 'N/A';

            })->setHtmlAttribute('style', 'min-width: 170px; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;'),

                AdminColumn::text('title', 'Title')
                    ->setHtmlAttribute('style', 'min-width: 100%;  max-width: 320px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;'),

                AdminColumn::text('content', 'Content')
                    ->setHtmlAttribute('style', 'min-width: 100%; max-width: 754px;  overflow: hidden; text-overflow: ellipsis; white-space: nowrap;'),

                AdminColumn::datetime('created_at', 'Created At')
                    ->setHtmlAttribute('style', 'min-width: 100%;  max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;')
                    ->setFormat('Y-m-d H:i:s'),

                AdminColumn::custom('Actions', function ($model) {
                        // some code...
                })->setView(view: 'admin.columns.actions')
                // ->setHtmlAttribute('class', attribute: 'text-center')
                    ->setHtmlAttribute('style', 'max-width: 300px; min-width : 300px;')


            ]);



        return $display;

    }

    public function isDeletable($model)
    {
        return false; // disables delete
    }


}
