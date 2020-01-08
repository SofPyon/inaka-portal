<?php

namespace App\Http\Controllers\Forms;

use App\Eloquents\Form;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;

class AllAction extends Controller
{
    public function __invoke()
    {
        $forms = Form::IsPublic()->CloseOrder()->get();
        $circle = Auth::user()->circles()->get();

        if (count($circle) === 1) {
            $circle = $circle[0];
        } elseif (count($circle) > 1) {
            return redirect()
                ->route('circles.selector.show', ['redirect' => 'forms.all']);
        }
        
        return view('v2.forms.list')
            ->with('forms', $forms)
            ->with('circle', $circle)
            ->with('now', new CarbonImmutable());
    }
}
