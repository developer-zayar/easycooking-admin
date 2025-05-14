<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\RecipeImage;

class RecipeImageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'RecipeImage';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new RecipeImage());

        $grid->model()->orderBy('id', 'desc');
        $grid->column('id', __('Id'))->sortable();
        $grid->column('recipe_id', __('Recipe id'))->sortable();
        $grid->column('name', __('Name'))->sortable();
        $grid->column('url', __('Url'))->image();
        $grid->column('content_type', __('Content type'))->sortable();
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
        $show = new Show(RecipeImage::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('recipe_id', __('Recipe id'));
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
        $form = new Form(new RecipeImage());

        $form->number('recipe_id', __('Recipe id'));
        $form->text('name', __('Name'));
        $form->url('url', __('Url'));
        $form->text('content_type', __('Content type'));
        $form->text('video_id', __('Video id'));
        $form->text('video_url', __('Video url'));

        return $form;
    }
}
