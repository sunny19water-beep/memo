<?php

namespace App\Http\Controllers;


use App\Models\Memo;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    public function store(Request $request)
    {

//
        Memo::create([
            'content' => $request->content,
        ]);
    }


    public function index(Request $request)
    {
        $search = $request->query('search');

        if ($search) {
            $memos = Memo::where('content', 'like', '%' . $search . '%')->get();
            return response()->json($memos);
        }else{
            $memos = Memo::all();
            return response()->json($memos);
        }
    }

    public function destroy(Memo $memo){
        $memo->delete();
    }

    public function update(Request $request, Memo $memo)
    {
        $memo->update([
            'content' => $request -> content,
        ]);
    }

    public function favorite(Memo $memo)
    {
        $memo->favorite = !$memo->favorite;
        $memo->save();
    }


}
