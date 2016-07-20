<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Services\JokeService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param JokeService $jokeService
     * @return \Illuminate\Http\Response
     */
    public function index(JokeService $jokeService)
    {
        return view('home')->with([
            'data' => $jokeService->getAll(),
        ]);
    }
}
