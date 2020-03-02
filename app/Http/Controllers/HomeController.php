<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * ホーム画面初期表示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        \Log::debug('てすと');
        return view('home');
    }

}
