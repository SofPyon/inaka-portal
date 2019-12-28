<?php

namespace App\Http\Controllers\Contacts;

use App\Eloquents\Circle;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class PostAction extends Controller
{
    public function __invoke(ContactFormRequest $request)
    {
        $user = Auth::user();
        $circle = Circle::find($request->circle_id);

        if (! Gate::allows('belongsTo', $circle)) {
            return redirect()
                ->route('contacts')
                ->with('error_message', 'エラーが発生しました')
                ->withErrors($request->validated)
                ->withInput();
        }

        // ここにメール送信のための処理を記述する

        return redirect()
            ->route('contacts')
            ->with('success_message', 'お問い合わせを受け付けました。');
    }
}
