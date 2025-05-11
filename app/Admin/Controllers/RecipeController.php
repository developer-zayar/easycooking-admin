<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Recipe;

class RecipeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Recipe';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Recipe());

        $grid->column('id', __('Id'));
        $grid->column('slug', __('Slug'));
        $grid->column('category_id', __('Category id'));
        $grid->column('post_id', __('Post id'));
        $grid->column('name', __('Name'));
        $grid->column('image', __('Image'))->image('', 100,100);
        // $grid->column('description', __('Description'));
        // $grid->column('instructions', __('Instructions'));
        // $grid->column('prep_time', __('Prep time'));
        // $grid->column('cook_time', __('Cook time'));
        $grid->column('status', __('Status'));
        $grid->column('view_count', __('View count'));
        $grid->column('fav_count', __('Fav count'));
        $grid->column('inactive', __('Inactive'));
        $grid->column('created_at', __('Created at'))->dateFormat('Y-m-d H:i:s');
        $grid->column('updated_at', __('Updated at'))->dateFormat('Y-m-d H:i:s');

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
        $show = new Show(Recipe::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('slug', __('Slug'));
        $show->field('category_id', __('Category id'));
        $show->field('post_id', __('Post id'));
        $show->field('name', __('Name'));
        $show->field('image', __('Image'));
        $show->field('description', __('Description'));
        $show->field('instructions', __('Instructions'));
        $show->field('prep_time', __('Prep time'));
        $show->field('cook_time', __('Cook time'));
        $show->field('status', __('Status'));
        $show->field('view_count', __('View count'));
        $show->field('fav_count', __('Fav count'));
        $show->field('inactive', __('Inactive'));
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
        $form = new Form(new Recipe());

        $form->text('slug', __('Slug'));
        $form->number('category_id', __('Category id'));
        $form->number('post_id', __('Post id'));
        $form->text('name', __('Name'));
        $form->url('image', __('Image'));
        $form->ckeditor('description', __('Description'));
        $form->textarea('instructions', __('Instructions'));
        $form->number('prep_time', __('Prep time'));
        $form->number('cook_time', __('Cook time'));
        $form->text('status', __('Status'))->default('draft');
        $form->number('view_count', __('View count'))->default(1);
        $form->number('fav_count', __('Fav count'));
        $form->switch('inactive', __('Inactive'));

        return $form;
    }
}
