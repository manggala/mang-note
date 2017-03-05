<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DateTime;
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
        $data['newNotes'] = [];
        foreach ($data['notes'] as $note) {
            array_push($data['newNotes'], [
                'id' => $note->id,
                'title' => $note->title,
                'content' => $note->content,
                'deadline' => $note->deadline,
                'is_done' => $note->is_done == true ? 1 : 0,
                'is_alerted' => $note->is_alerted == true ? 1 : 0,
                'label_id' => $note->label_id,
                'label_title' => isset($note->label->title) ? $note->label->title : 'No Label'
            ]);
        }
        return response($data['newNotes']);
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

    public function getUpcomingNotes(){
        $start_date = new DateTime(date('Y-m-d H:i:s'));
        $stop_date = new DateTime(date('Y-m-d H:i:s'));
        $stop_date->modify('+1 day');
        $notes = Note::where('user_id', Auth::user()->id)
            ->where('is_done', 0)
            ->where('is_alerted', 0)
            ->whereBetween('deadline', [$start_date, $stop_date])
            ->get();
        return response($notes);
    }

    public function gotThis($id){
        $note = Note::where('user_id', Auth::user()->id)->find($id);
        if (empty($note))
            return response(['status' => 'not found'], 404);
        $note->is_alerted = 1;
        $note->save();
        return response(['status' => 'read']);
    }
}
