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

        $this->meta
            ->loadPackage(['jquery', 'ckeditor'])
            ->setTitle('Activities test')
            ->setMetaDescription('test')
            ->addMeta(['name' => 'og:title', 'content' => 'Title'])
            ->putVars(
                'activities', $activities
            );

        return view('home', compact('activities'));
    }
}
