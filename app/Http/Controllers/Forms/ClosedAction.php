<?php

namespace App\Http\Controllers\Forms;

use App\Eloquents\Circle;
use App\Eloquents\Form;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ClosedAction extends Controller
{
    public function __invoke()
    {
        $forms = Form::public()->closed()->closeOrder()->get();
        $circle = Circle::find(request('circle'));
        if (isset($circle) && Gate::allows('circle.belongsTo', $circle)) {
        } else {
            $circles = Auth::user()->circles()->get();

            if (count($circles) === 1) {
                $circle = $circles[0];
            } elseif (count($circles) > 1) {
                return redirect()
                    ->route('circles.selector.show', ['redirect' => 'forms.closed']);
            }
        }

        return view('v2.forms.list')
            ->with('forms', $forms)
            ->with('circle', $circle)
            ->with('now', now());
    }
}
