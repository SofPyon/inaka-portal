<?php

namespace App\Http\Controllers\Documents;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquents\Document;

class IndexAction extends Controller
{
    public function __invoke()
    {
        $documents = Document::public()->with('schedule')->get();
        $documents = count($documents) > 0 ? $documents : [];
        return view('v2.documents.index')
            ->with('documents', $documents);
    }
}
