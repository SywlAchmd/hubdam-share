<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DivisiController extends Controller
{
    /**
     * Fetching data based on staff type
     *
     * @param string $uri
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index($uri, Request $request)
    {
        $type = explode('-', $uri)[1];

        if (!$type) {
            return Inertia::render('Divisi/Staff', [
                'staff' => [],
                'type' => 'Unknown',
            ]);
        }

        $query = User::query();

        $query->where('staff', $type);

        if ($request->has('search') && $request->search !== '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $staff = $query->paginate(6);

        return Inertia::render('Divisi/Staff', [
            'staff' => $staff,
            'type' => $type,
        ]);
    }
}
