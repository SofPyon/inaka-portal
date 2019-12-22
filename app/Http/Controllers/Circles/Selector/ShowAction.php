<?php

namespace App\Http\Controllers\Circles\Selector;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;

class ShowAction extends Controller
{
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function __invoke(Request $request)
    {
        $redirect = (string) $request->redirect;
        if (isset($redirect) && $this->router->has($redirect)) {
            $user = Auth::user();
            $circles = $user->circles->all();

            if (count($circles) <= 1) {
                return redirect()
                    ->route($redirect);
            }

            return view('circles.selector')
                ->with('redirect', $redirect)
                ->with('circles', $circles);
        }
        
        return redirect()
            ->route('home');
    }
}
