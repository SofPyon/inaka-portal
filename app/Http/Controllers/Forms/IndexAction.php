<?php

namespace App\Http\Controllers\Forms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquents\Form;

class IndexAction extends Controller
{
    public function __invoke()
    {
        $forms = Form::IsPublic()->NowOpend()->OpenOrder()->get();
        return view('v2.forms.list')
            ->with('forms', $forms);
    }
}
