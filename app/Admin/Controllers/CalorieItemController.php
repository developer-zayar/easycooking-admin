<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\CalorieItem;

class CalorieItemController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'CalorieItem';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CalorieItem());

        $grid->model()->orderBy('id', 'desc');
        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('Name'))->sortable();
        $grid->column('category', __('Category'))->sortable();
        $grid->column('category_key', __('Category key'))->sortable();
        $grid->column('weight', __('Weight'))->sortable();
        $grid->column('calories', __('Calories'))->sortable();
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
        $show = new Show(CalorieItem::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('category', __('Category'));
        $show->field('category_key', __('Category key'));
        $show->field('weight', __('Weight'));
        $show->field('calories', __('Calories'));
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
        $form = new Form(new CalorieItem());

        $form->text('name', __('Name'));
        $form->text('category', __('Category'));
        $form->text('category_key', __('Category key'));
        $form->text('weight', __('Weight'));
        $form->number('calories', __('Calories'));

        return $form;
    }
}
