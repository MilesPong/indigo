<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.home');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Foundation\Application|\JellyBool\Translug\Translation|mixed|string|\translug
     */
    public function autoSlug(Request $request)
    {
        $this->validate($request, [
            'text' => 'required',
        ]);

        return str_slug_with_cn($request->input('text'));
    }
}
