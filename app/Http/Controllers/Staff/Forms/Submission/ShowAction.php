<?php

namespace App\Http\Controllers\Staff\Forms\Submission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquents\Form;

class ShowAction extends Controller
{
    public function __construct()
    {
    }

    public function __invoke(Form $form)
    {
        return view('staff.forms.unsubmit')
            ->with('form', $form);
    }
}
