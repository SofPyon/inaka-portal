<?php

namespace App\Http\Controllers\Contacts;

use App\Eloquents\Circle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CreateAction extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        $circles = $user->circles->all();

        if (empty($circles)) {
            return view('contacts.form');
        }
        
        return view('contacts.form')
            ->with('circles', $circles);
    }
}
