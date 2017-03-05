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

    public function markThis($id){
        $notes = Note::where('user_id', Auth::user()->id)->find($id);
        if (empty($notes))
            return response(['status' => 'failed', 'message' => 'Note not found'], 404);
        if ($notes->is_done == 1){
            $notes->is_done = 0;
            $notes->save();
            return response(['status' => 'success', 'message' => 'Note not found', 'action' => 'unmark']);
        } else {
            $notes->is_done = 1;
            $notes->save();
            return response(['status' => 'success', 'message' => 'Note not found', 'action' => 'mark']);
        }
    }
}
