<?php

namespace App\Http\Controllers;

use App\Models\PageContent;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageContentController extends Controller
{
    public function index()
    {
        $pageContent = PageContent::all();
        $vision = $pageContent->where('type', 'vision')->first();
        $mission = $pageContent->where('type', 'mission')->first();

        return Inertia::render('Beranda', ['vision' => $vision, 'mission' => $mission]);
    }
}
