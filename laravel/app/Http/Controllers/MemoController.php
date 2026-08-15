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


    public function index()//ここに呼ばれたときにDBの内容を全部jsonにしてContentDisplayに送信する
    {
        $memos = Memo::all();
        return response()->json($memos);
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


}
