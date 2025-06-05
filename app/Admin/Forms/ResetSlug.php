<?php

namespace App\Admin\Forms;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use OpenAdmin\Admin\Widgets\Form;

class ResetSlug extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = 'Reset Slug';

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
        $tableName = $request->get('table_name');
        if (!in_array($tableName, ['posts', 'recipes'])) {
            admin_toastr('Invalid table name', 'warning');
            return back();
        }

        $singular = Str::singular($tableName);
        $pattern = "/^" . preg_quote($singular) . "-[a-zA-Z0-9]{10}$/";

        $records = DB::table($tableName)
            ->select('id', 'slug')
            ->get();

        $updated = 0;
        foreach ($records as $record) {
            if (!preg_match($pattern, $record->slug)) {
                DB::table($tableName)
                    ->where('id', $record->id)
                    ->update([
                        'slug' => $singular . '-' . Str::random(10),
                    ]);
                $updated++;
            }
        }

        admin_toastr("Updated $updated slug(s) for table: $tableName.", 'success');

//        admin_success('Processed successfully.');

        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->select('table_name')
            ->options(['recipes' => 'Recipe Table', 'posts' => 'Post Table'])
            ->default('recipes')
            ->required();

//        $this->text('name')->rules('required');
//        $this->email('email')->rules('email');
//        $this->datetime('created_at');
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
