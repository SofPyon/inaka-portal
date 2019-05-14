<?php

namespace App\Http\Controllers\Auth\Email;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VerifyNoticeAction extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke()
    {
        return view('auth.verify');
    }
}
