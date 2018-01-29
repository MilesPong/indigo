<?php

namespace App\Http\Controllers\Backend\Helpers;

use App\Http\Controllers\Backend\BackendController;
use Illuminate\Http\Request;

class SlugController extends BackendController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function translate(Request $request)
    {
        $this->validate($request, [
            'text' => 'required',
        ]);

        $text = $request->input('text');

        return $this->respondWith([
            'text' => $text,
            'slug' => str_slug_with_cn($text)
        ]);
    }
}