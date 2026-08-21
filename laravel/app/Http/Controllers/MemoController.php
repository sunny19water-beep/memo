<?php

namespace App\Http\Controllers;


use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

    // AI要約
    public function summarize(Request $request)
    {
        $response = Http::withToken(env('SAKURA_API_KEY'))
            ->post('https://api.ai.sakura.ad.jp/v1/chat/completions', [
                'model' => 'gpt-oss-120b',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => '入力された文章を日本語で簡潔に要約してください。要約文だけを1文で返してください。説明や前置きは不要です。',
                    ],
                    [
                        'role' => 'user',
                        'content' => $request->content,
                    ],
                ],
            ]);

        if ($response->failed()) {
            return response()->json([
                'message' => 'AI APIとの通信に失敗しました。',
                'error' => $response->json(),
            ], 500);
        }

        $summary = $response->json('choices.0.message.content');

        if (!$summary) {
            return response()->json([
                'message' => 'AIから要約結果を取得できませんでした。',
            ], 500);
        }

        return response()->json([
            'summary' => trim($summary),
        ]);
    }








}
