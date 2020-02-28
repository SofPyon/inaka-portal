<?php

namespace App\Http\Controllers\Staff\Forms\Answers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquents\Form;

class DownloadZipAction extends Controller
{
    public function __invoke(Form $form)
    {
        $form->load('answers.details');
        dd((array)$form->answers->toArray());
    }
}
