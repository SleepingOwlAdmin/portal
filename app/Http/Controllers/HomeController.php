<?php

namespace App\Http\Controllers;

use App\Activity;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = Activity::orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        return view('home', compact('activities'));
    }
}
