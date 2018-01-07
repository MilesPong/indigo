<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

class DashboardController extends BackendController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.home');
    }

    /**
     * TODO temp location
     *
     * @param Request $request
     * @return string
     */
    public function createSlug(Request $request)
    {
        $this->validate($request, [
            'text' => 'required',
        ]);

        return str_slug_with_cn($request->input('text'));
    }
}
