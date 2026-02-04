<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
class ApplicationController extends Controller
{
    /**
     * Show the landing page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('landing-page');
    }

    /**
     * Show the about us page
     *
     * @return \Illuminate\View\View
     */
    public function aboutUs()
    {
        // Get the last 3 blogs ordered by created_at
        $blogs = Blog::latest()->take(3)->orderBy('created_at', 'desc')->get();
        return view('application.about-us', compact('blogs'));
    }

    /**
     * Show the help page
     *
     * @return \Illuminate\View\View
     */
    public function help()
    {
        return view('application.help-view');
    }

    /**
     * Show the category page
     *
     * @return \Illuminate\View\View
     */
    public function category($title, $description)
    {
        return view('application.category-view', compact('title', 'description'));
    }
}
