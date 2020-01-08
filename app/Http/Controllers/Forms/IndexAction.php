<?php

namespace App\Http\Controllers\Forms;

use App\Eloquents\Circle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquents\Form;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;

class IndexAction extends Controller
{
    public function __invoke()
    {
        $forms = Form::IsPublic()->NowOpend()->CloseOrder()->get();
        $circle = Auth::user()->circles()->get();

        if (count($circle) === 1) {
            $circle = $circle[0];
        } elseif (count($circle) > 1) {
            return redirect()
                ->route('circles.selector.show', ['redirect' => 'fomrs.index']);
        }

        return view('v2.forms.list')
            ->with('forms', $forms)
            ->with('circle', $circle)
            ->with('now', new CarbonImmutable());
    }
}
