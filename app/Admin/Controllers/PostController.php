<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Post;

class PostController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Post';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Post());

        $grid->model()->orderBy('id', 'desc');
        $grid->column('id', __('Id'))->sortable();
        $grid->column('title', __('Title'));
        $grid->column('slug', __('Slug'))->sortable();
        $grid->column('tags', __('Tags'));
        $grid->column('status', __('Status'))->sortable();
        // $grid->column('content', __('Content'));
        $grid->column('view_count', __('View count'));
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
        $show = new Show(Post::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('slug', __('Slug'));
        $show->field('tags', __('Tags'));
        $show->field('status', __('Status'));
        $show->field('content', __('Content'));
        $show->field('view_count', __('View count'));
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
        $form = new Form(new Post());

        $form->text('title', __('Title'));
        $form->textarea('slug', __('Slug'));
        $form->text('tags', __('Tags'));
        $form->text('status', __('Status'))->default('draft');
        $form->ckeditor('content', __('Content'));
        $form->number('view_count', __('View count'))->default(1);

        return $form;
    }
}
