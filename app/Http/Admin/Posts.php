<?php

namespace App\Http\Admin;

use AdminColumn;
use AdminFormElement;
use App\Post;
use Carbon\Carbon;
use SleepingOwl\Admin\Contracts\DisplayInterface;
use SleepingOwl\Admin\Contracts\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

/**
 * Class Posts
 * @package App\Http\Admin
 *
 * @property Post $model
 */
class Posts extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Posts';

    /**
     * @var string
     */
    protected $icon = 'fa fa-newspaper-o';

    /**
     * Initialize class.
     */
    public function initialize()
    {
        $this->addToNavigation(100);
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        return \AdminDisplay::table()
            ->setScopes('latest')
            ->setColumns(
                AdminColumn::image('thumb', 'Image')->setWidth('100px'),
                AdminColumn::link('title', 'Title'),
                AdminColumn::datetime('created_at', 'Created At')->setWidth('150px')
            );
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        return \AdminForm::panel()
            ->setHtmlAttribute('enctype', 'multipart/form-data')
            ->addHeader(
                AdminFormElement::text('title', 'Title')->required(),
                AdminFormElement::date('created_at', 'Created At')
                    ->setFormat('Y-m-d H:i:s')
                    ->setDefaultValue(Carbon::now())
                    ->required()
            )
            ->addBody(
                AdminFormElement::wysiwyg('text_source', 'Text', 'simplemde')
                    ->required()
                    ->disableFilter()
            )
            ->addBody(
                AdminFormElement::upload('upload_image', 'Image')
                    ->addValidationRule('image'),
                AdminColumn::image('thumb'),

                AdminFormElement::custom(function (Post $post) {
                   if(is_null($post->user_id)) {
                       $post->assignUser(auth()->user());
                   }
                })
            );
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }
}
