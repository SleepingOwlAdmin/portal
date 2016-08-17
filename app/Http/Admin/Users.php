<?php

namespace App\Http\Admin;

use AdminColumn;
use AdminDisplay;
use AdminFormElement;
use App\User;
use SleepingOwl\Admin\Contracts\DisplayInterface;
use SleepingOwl\Admin\Contracts\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

/**
 * Class Users
 * @package App\Http\Admin
 *
 * @property User $model
 */
class Users extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Users';

    /**
     * @var string
     */
    protected $icon = 'fa fa-group';

    /**
     * Initialize class.
     */
    public function initialize()
    {
        $this->addToNavigation(200);
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        return AdminDisplay::table()
            ->setColumns(
                AdminColumn::image('avatar', 'Avatar')->setWidth('100px'),
                AdminColumn::link('name', 'Name'),
                AdminColumn::email('email', 'E-mail')->setWidth('200px')
            )
            ->setNewEntryButtonText('New user');
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
                AdminFormElement::text('name', 'Name')->required(),
                AdminFormElement::text('email', 'E-mail')
                    ->required()
                    ->addValidationRule('email')
            )
            ->addBody(
                AdminFormElement::image('avatar', 'Avatar')
            )
            ->addBody(
                AdminFormElement::password('password', 'Password')
                    ->required()
                    ->addValidationRule('min:6')
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
