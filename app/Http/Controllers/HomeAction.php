<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Eloquents\Page;
use App\Eloquents\Schedule;
use App\Eloquents\Document;

class HomeAction extends Controller
{
    /**
     * 表示するお知らせ・配布資料の最大数
     */
    private const TAKE_COUNT = 5;

    public function __construct()
    {
        // TODO: 将来的には、非ログイン状態でもこのページが表示されるようにする
        $this->middleware('auth');
    }

    public function __invoke()
    {
        $pages = Page::take(self::TAKE_COUNT)->get();
        $pages = count($pages) > 0 ? $pages : [];

        $documents = Document::take(self::TAKE_COUNT)->public()->with('schedule')->get();
        $documents = count($documents) > 0 ? $documents : [];

        return view('v2.home')
            ->with('my_circles', Auth::user()->circles)
            ->with('pages', $pages)
            ->with('remaining_pages_count', max(Page::count() - self::TAKE_COUNT, 0))
            ->with('next_schedule', Schedule::startOrder()->notStarted()->first())
            ->with('documents', $documents)
            ->with('remaining_documents_count', max(Document::public()->count() - self::TAKE_COUNT, 0));
    }
}
