<?php
namespace App\Admin\Sections;

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


class Posts extends Section
{
    protected $model = Post::class;
    protected $title = 'Posts';

    public function onDisplay(): DisplayInterface
    {
        return AdminDisplay::datatablesAsync()
            ->setName('posts-table')
            ->setHtmlAttributes(['class' => 'table table-bordered'])
            ->setDisplaySearch(true)
            ->setDisplayLength(true)
            ->with('user') // 👈 this is important!
            ->setColumns([
                AdminColumn::text('id', 'ID')
                ->setWidth('40px')
                ->setHtmlAttribute('class', 'text-center'),
                 AdminColumn::text('user.name', 'Username') // 👈 show username
                ->setWidth('150px')
                ->setHtmlAttribute('class', 'text-center'),
                AdminColumn::text('title', 'Title')->setWidth('300px'),
                AdminColumn::text('content', 'Content'),
                AdminColumn::datetime('created_at', 'Created At')
                ->setWidth('170px')
                ->setHtmlAttribute('class', 'text-center')
                ->setFormat('Y-m-d H:i:s'),

                AdminColumn::custom('Actions', function ($model) {
                    $editUrl = route('admin.model.edit', ['posts', $model->id]);
                    $deleteUrl = route('admin.model.delete', ['posts', $model->id]);

                    return <<<HTML
                        <a href="{$editUrl}" class="btn btn-sm btn-primary">✏️</a>
                        <form method="POST" action="{$deleteUrl}" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                            <input type="hidden" name="_token" value="">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-sm btn-danger">🗑</button>
                        </form>
                    HTML;
                })
                ->setHtmlAttribute('class', 'text-center')
                ->setWidth('100px')
            ]);
    }
}
