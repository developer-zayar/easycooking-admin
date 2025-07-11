<?php

namespace App\Admin\Forms;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use OpenAdmin\Admin\Widgets\Form;

class Setting extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = 'Website Settings';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        //dump($request->all());

        admin_success('Processed successfully.');

        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->text('name')->rules('required');
        $this->email('email')->rules('email');
        $this->datetime('created_at');
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return [
            'name' => 'John Doe',
            'email' => 'John.Doe@gmail.com',
            'created_at' => now(),
        ];
    }
}
