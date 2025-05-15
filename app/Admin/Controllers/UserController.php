<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\User;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->model()->orderBy('id', 'desc');
        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('Name'))->sortable();
        $grid->column('email', __('Email'))->sortable();
        $grid->column('phone', __('Phone'));
        $grid->column('image', __('Image'))->image('', 50,50);
        $grid->column('email_verified_at', __('Email verified at'));
        $grid->column('password', __('Password'));
        $grid->column('otp', __('Otp'));
        $grid->column('otp_expires_at', __('Otp expires at'));
        $grid->column('provider', __('Provider'));
        $grid->column('provider_id', __('Provider id'));
        $grid->column('remember_token', __('Remember token'));
        $grid->column('device_id', __('Device id'))->sortable();
        $grid->column('device_name', __('Device name'))->sortable();
        // $grid->column('fcm_token', __('Fcm token'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('phone', __('Phone'));
        $show->field('image', __('Image'));
        $show->field('email_verified_at', __('Email verified at'));
        $show->field('password', __('Password'));
        $show->field('otp', __('Otp'));
        $show->field('otp_expires_at', __('Otp expires at'));
        $show->field('provider', __('Provider'));
        $show->field('provider_id', __('Provider id'));
        $show->field('remember_token', __('Remember token'));
        $show->field('device_id', __('Device id'));
        $show->field('device_name', __('Device name'));
        $show->field('fcm_token', __('Fcm token'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('name', __('Name'));
        $form->email('email', __('Email'));
        $form->phonenumber('phone', __('Phone'));
        $form->image('image', __('Image'));
        $form->datetime('email_verified_at', __('Email verified at'))->default(date('Y-m-d H:i:s'));
        $form->password('password', __('Password'));
        $form->text('otp', __('Otp'));
        $form->datetime('otp_expires_at', __('Otp expires at'))->default(date('Y-m-d H:i:s'));
        $form->text('provider', __('Provider'));
        $form->text('provider_id', __('Provider id'));
        $form->text('remember_token', __('Remember token'));
        $form->text('device_id', __('Device id'));
        $form->text('device_name', __('Device name'));
        $form->text('fcm_token', __('Fcm token'));

        return $form;
    }
}
