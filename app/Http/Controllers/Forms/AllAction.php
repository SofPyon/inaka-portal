<?php

namespace App\Http\Controllers\Forms;

use App\Eloquents\Form;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AllAction extends Controller
{
    public function __invoke()
    {
        $forms = Form::IsPublic()->OpenOrder()->get();
        
        return view('v2.forms.list')
            ->with('forms', $forms);
    }
}
