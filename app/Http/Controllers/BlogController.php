<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('is_featured', '!=', true)->get();
        $featuredBlog = Blog::where('is_featured', true)->first();
        return view('application.blog', ['blogs' => $blogs, 
                                         'featuredBlog' => $featuredBlog]);
    }

    public function show($slug)
    {
        $post = Blog::where('slug', $slug)->first();
        return view('application.post', ['post' => $post]);
    }
}
