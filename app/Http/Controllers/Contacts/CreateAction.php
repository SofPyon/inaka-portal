<?php

namespace App\Http\Controllers\Contacts;

use App\Eloquents\Circle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CreateAction extends Controller
{
    public function __invoke(Circle $circle = null)
    {
        $user = Auth::user();

        if (!empty($circle)) { // セレクターから circle をもらっている場合
            if (empty($user->circles->where('id', $circle->id)->first())) {
                return redirect()
                    ->route('home');
            }
            return view('contacts.form')
                ->with('circle', $circle);
        }

        $circles = $user->circles->all();

        if (empty($circles)) { // 団体に所属していない場合
            return view('contacts.form');
        }

        if (count($circles) == 1) { // １団体のみに所属している場合
            return view('contacts.form')
                ->with('circle', $circles[0]);
        }

        if (count($circles) > 1) { // ２団体以上に所属している場合
            return redirect()
                ->route('circles.selector.show', ['redirect' => 'contacts']);
        }

        return route('home')
            ->with('error_message', 'エラーが発生しました。');
    }
}
