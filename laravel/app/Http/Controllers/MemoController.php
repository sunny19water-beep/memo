<?php

namespace App\Http\Controllers;


use App\Models\Memo;
use Illuminate\Http\Request;

class MemoController extends Controller
{
//    public function store(Request $request)
//    {
//
////        dd($request->content);
//        Memo::create([
//            'content' => $request->content,
//        ]);
//    }

    public function store(Request $request)
    {
        return response()->json([
            'received' => $request->all(),
        ]);
    }

    public function index()//ここに呼ばれたときにDBの内容を全部jsonにしてContentDisplayに送信する
    {
        $memos = Memo::all();
        return response()->json($memos);

    }


}
