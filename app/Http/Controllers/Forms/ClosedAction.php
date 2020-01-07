<?php

namespace App\Http\Controllers\Forms;

use App\Eloquents\Form;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClosedAction extends Controller
{
    public function __invoke()
    {
        $forms = Form::IsPublic()->NowClosed()->OpenOrder()->get();
        return view('v2.forms.list')
            ->with('forms', $forms);
    }
}
