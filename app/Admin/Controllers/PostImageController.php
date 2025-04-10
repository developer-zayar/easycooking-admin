<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\PostImage;

class PostImageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'PostImage';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PostImage());

        $grid->column('id', __('Id'));
        $grid->column('post_id', __('Post id'));
        $grid->column('name', __('Name'));
        $grid->column('url', __('Url'))->image();
        $grid->column('content_type', __('Content type'));
        $grid->column('video_id', __('Video id'));
        $grid->column('video_url', __('Video url'));
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
        $show = new Show(PostImage::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('post_id', __('Post id'));
        $show->field('name', __('Name'));
        $show->field('url', __('Url'));
        $show->field('content_type', __('Content type'));
        $show->field('video_id', __('Video id'));
        $show->field('video_url', __('Video url'));
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
        $form = new Form(new PostImage());

        $form->number('post_id', __('Post id'));
        $form->text('name', __('Name'));
        $form->url('url', __('Url'));
        $form->text('content_type', __('Content type'));
        $form->text('video_id', __('Video id'));
        $form->text('video_url', __('Video url'));

        return $form;
    }
}
