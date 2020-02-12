<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquents\Page;

class IndexAction extends Controller
{
    public function __invoke()
    {
        $pages = Page::all();
        $pages = count($pages) > 0 ? $pages : [];
        return view('v2.pages.index')
            ->with('pages', $pages);
    }
}
