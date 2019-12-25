<?php

namespace App\Http\Controllers\Contacts;

use App\Eloquents\Circle;
use Illuminate\Http\Request;
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

        $validated = $request->validated();

        if ($validated->fails()) {
            return redirect()
                ->route('contacts')
                ->withErrors($validated)
                ->withInput();
        }

        // ここにメール送信のための処理を記述する

        return redirect()
            ->route('home')
            ->with('success_message', 'お問い合わせを受け付けました。');
    }
}
