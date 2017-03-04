<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Note;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function restNote(){
        $data['notes'] = Note::orderBy('deadline', 'desc')->paginate(6);
        return response($data['notes']);
    }
}
