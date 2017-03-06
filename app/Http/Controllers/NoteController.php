<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Label;
use App\Note;
class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get all label related to user
        $data['label'] = Label::where('user_id', Auth::user()->id)->get();
        // Convert from Label class model into array that used by form
        $data['dropdownLabel'] = [];
        foreach ($data['label'] as $label) {
            $data['dropdownLabel'][$label->id] = $label->title;
        }
        return view('pages.note.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try {
            $time = strtotime($request->deadlineDate . " " . $request->deadlineTime);
            $newFormat = date('Y-m-d H:i:s', $time);
            try {
                Note::create([
                    'title' => $request->title,
                    'content' => $request->content,
                    'deadline' => $newFormat,
                    'label_id' => $request->label_id,
                    'user_id' => Auth::user()->id,
                ]);
                // Creating SUCCESS message notification
                $request->session()->put('notification', ['type' => 'success', 'message' => 'Successfull adding notes']);
            } catch (Exception $e) {
                // Creating ERROR message notification
                $request->session()->put('notification', ['type' => 'error', 'message' => 'Some form input is not properly entered']);
            }
        } catch (Exception $e) {
            // Creating ERROR message notification
            $request->session()->put('notification', ['type' => 'error', 'message' => 'Wrong tipe of time, read the form carefully']);
        }
        return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
