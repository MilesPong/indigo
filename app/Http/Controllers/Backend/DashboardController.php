<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class DashboardController extends BackendController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // Haven't use repository instead.
        $postCount = Post::withoutGlobalScopes()->count();
        $pageCount = Page::withoutGlobalScopes()->count();
        $categoryCount = Category::withoutGlobalScopes()->count();
        $tagCount = Tag::withoutGlobalScopes()->count();

        return view('admin.home', compact('postCount', 'pageCount', 'categoryCount', 'tagCount'));
    }
}
