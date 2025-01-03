<?php

namespace App\Http\Controllers;

use App\Models\PageContent;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PageContentController extends Controller
{
    /**
     * Display Beranda
     * @return Response
     */
    public function index(): Response
    {
        $pageContent = PageContent::all();
        $vision = $pageContent->where('type', 'vision')->first();
        $mission = $pageContent->where('type', 'mission')->first();

        return Inertia::render('Beranda', ['vision' => $vision, 'mission' => $mission]);
    }
}
