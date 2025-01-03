<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DivisiController extends Controller
{
    /**
     * fetching data base on staff route
     * @param uri $url
     * @return array $staff
     */
    public function index($uri)
    {
        $staffKey = explode('-', $uri)[1] ?? null;

        if (!$staffKey) {
            return Inertia::render('Divisi/Staff', [
                'staff' => [],
            ]);
        }

        $staff = User::where('staff', $staffKey)->paginate(6);

        return Inertia::render('Divisi/Staff', [
            'staff' => $staff,
            'type' => $staffKey
        ]);
    }
}
