<?php

namespace App\Http\Controllers\Staff\Forms\Answers\NotAnswered;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquents\Form;
use App\Eloquents\Circle;

class ShowAction extends Controller
{
    public function __construct(Circle $circle)
    {
        $this->circle = $circle;
    }

    public function __invoke(Form $form)
    {
        $answers = $form->answers;
        foreach ($answers as $answer) {
            $submit_circle_ids[] = $answer->circle_id;
        }
        $submit_circle_ids = array_unique($submit_circle_ids);

        $circles = $this->circle->whereNotIn('id', $submit_circle_ids)->get();

        return view('v2.staff.forms.answers.notanswered.index')
            ->with('form', $form)
            ->with('circles', $circles);
    }
}
