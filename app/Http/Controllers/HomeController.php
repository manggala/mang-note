<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Label;
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
        $data['labels'] = Label::where('user_id', Auth::user()->id)->get();
        return view('home', compact('data'));
    }

    public function restNote(){
        $data['notes'] = Note::orderBy('deadline', 'asc')->get();
        return response($data['notes']);
    }
}
