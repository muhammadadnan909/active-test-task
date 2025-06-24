<?php
namespace App\Admin\Sections;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use SleepingOwl\Admin\Form\FormElements;
use AdminDisplay;
use AdminForm;
use AdminColumn;
use AdminFormElement;
use App\Models\Post;

class Posts extends Section
{
    protected $model = Post::class;

    protected $title = 'Posts';

    public function onDisplay(): DisplayInterface
    {
        return AdminDisplay::table()
            ->setColumns([
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumn::link('title', 'Title'),
                AdminColumn::text('author', 'Author'),
                AdminColumn::datetime('created_at', 'Created')->setFormat('d.m.Y H:i'),
            ])
            ->paginate(25);
    }

    public function onEdit($id): FormInterface
    {
        return AdminForm::panel()->addBody([
            AdminFormElement::text('title', 'Title')->required(),
            AdminFormElement::textarea('content', 'Content')->required(),
            AdminFormElement::text('author', 'Author'),
        ]);
    }

    public function onCreate(): FormInterface
    {
        return $this->onEdit(null);
    }

    public function onDelete($id)
    {
        // Laravel handles this automatically, no need to implement
    }
}
