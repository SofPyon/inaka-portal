<?php

namespace App\Http\Controllers\Contacts;

use App\Eloquents\Circle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostAction extends Controller
{
    public function __invoke(Circle $circle = null, Request $request)
    {
        $user = Auth::user();

        if (!empty($circle) && empty($user->circles->where('id', $circle->id)->first())) {
            return redirect()
                ->route('contacts')
                ->with('error_message', '権限がありません');
        }

        $validate = Validator::make($request->all(), [
            'contact-body' => 'required',
        ], [
            'contact-body.required' => 'お問い合わせ内容は必ず入力してください',
        ]);

        if ($validate->fails()) {
            if (empty($circle)) {
                return redirect()
                    ->route('contacts')
                    ->withErrors($validate)
                    ->withInput();
            }
            return redirect()
                ->route('contacts', ['circle' => $circle])
                ->withErrors($validate)
                ->withInput();
        }

        return redirect()
            ->route('home')
            ->with('success_message', 'お問い合わせを受け付けました。');
    }
}
