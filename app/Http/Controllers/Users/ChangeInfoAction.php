<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChangeInfoAction extends Controller
{
    public function __invoke()
    {
        return view('users.form')
            ->with('user', Auth::user());
    }
}
