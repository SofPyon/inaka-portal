<?php

namespace App\Http\Controllers\Contacts;

use App\Eloquents\Circle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostAction extends Controller
{
    public function __invoke(Circle $circle = null)
    {
        return 0;
    }
}
