<?php

namespace App\Http\Controllers\Notes;

use App\Enums\SystemCode;
use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class NotesController extends Controller
{

    public function index()
    {
        try {
            $notes = Note::select('code', 'title', 'description')
                ->where('status', '=', 1)
                ->get();
            return response()->json(['status' => 200, 'notes' => $notes]);
        } catch (\Exception $e) {
            return  response()->json([
                'status' => 500,
                'message' => $e
            ]);
        }
    }

    public function show($id)
    {
        try {
            $note = Note::select('code', 'title', 'description')
                ->where('code', '=', $id)->where('status', '=', 1)
                ->first();
            return response()->json(['status' => 200, 'note' => $note]);
        } catch (\Exception $e) {
            return  response()->json([
                'status' => 500,
                'message' => $e
            ]);
        }
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        try {
            $sys_code = SystemCode::NoteCode; 
            $max_code = Note::max('code');
            $Note_code = $max_code == null ? config('global.code_value') + 1 : substr("$max_code", 3) + 1;

            Note::create([
                'code' => $sys_code . $Note_code,
                'title' => $request->title,
                'description' => $request->description,
                'created_at'=> date('Y-m-d H:i:s')
            ]);
            return response()->json(['status' => 200, 'Message' => 'Note Created']);
        } catch (\Exception $e) {
            return  response()->json([
                'status' => 500,
                'message' => $e
            ]);
        }
    }





    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        try {

            $Note = Note::where('code', $id)->first();
            $Note->update([
                'title' => $request->title,
                'description' => $request->description,
                'updated_at'=> date('Y-m-d H:i:s')
            ]);
            return response()->json(['status' => 200, 'Message' => 'Note Updated']);
        } catch (\Exception $e) {
            return  response()->json([
                'status' => 500,
                'message' => $e
            ]);
        }
    }


    public function destroy($id)
    {
        try {
            $Note = Note::where('code', $id)->delete();
            return response()->json(['status' => 200, 'Message' => 'Note Delete']);
        } catch (\Exception $e) {
            return  response()->json([
                'status' => 500,
                'message' => $e
            ]);
        }
    }
}
