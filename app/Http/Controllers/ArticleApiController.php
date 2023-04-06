<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\artikelInsert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ArticleApiController extends Controller
{
    //
    public function index()
    {
        return artikelInsert::all();
    }

    /* public function search_api($name)
     {
         $result = DB::table('ab_article')
             ->whereRaw("lower(ab_name) like '%" . $name . "%'")
             ->get();
         return response()->json(['name' => $result]);
     }*/

    public function search_api(Request $request)
    {
        $result = DB::table('ab_article')
            ->whereRaw("lower(ab_name) like '%" . $request->search . "%'")
            ->get();
        return response()->json($result);

    }

    public function add_api(Request $request)
    {
        $rules = [
            'ab_name' => 'required|string',
            'ab_price' => 'required|integer|min:1',
            'ab_description' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()]);
        } else {
            $values = [
                'ab_name' => $request->ab_name,
                'ab_price' => $request->ab_price,
                'ab_description' => $request->ab_description,
                'ab_creator_id' => 1,
                'ab_createdate' => Carbon::now()->toDateTimeString()
            ];
            $result = DB::table('ab_article')->insert($values);

            $id = artikelInsert::where('ab_name', $request->ab_name)->value('id');

            if ($result) {
                return response()->json(['status' => 200, 'id' => $id, 'msg' => 'Saved successfully']);
            } else {
                return response()->json(['status' => 400, 'error' => 'Something went wrong']);
            }
        }
    }

    public function delete_api($id)
    {
        $article = artikelInsert::find($id);
        $result = $article->delete();

        if ($result) {
            return response()->json(['status' => 200, 'msg' => $id . ' was deleted successfully']);
        } else {
            return response()->json(['status' => 400, 'msg' => ' Delete failed']);
        }
    }

//    M5 A10
    public function artikelInAngebot(Request $request)
    {
        $artikelId = $request->artikelid ?? '';
        $artikelName = $request->artikelname ?? '';
        $userId = $request->userid ?? '';

        $users = DB::table('ab_user')->where('liked_article', 'like', '%|1|%')->get('id')->toArray();
        var_dump($users);
        $interessierteUsers = '';
        foreach ($users as $obj) {
            $interessierteUsers = $interessierteUsers . '|'. $obj->id.
                '|';
        }

        $msg = 'gebe an ,' . $interessierteUsers . ', Der Artikel ' . $artikelName . ' wird nun günstiger angeboten! Greifen Sie schnell zu' . ',' . $artikelId;

        \Ratchet\Client\connect('ws://localhost:8085/chat')->then(function ($conn) use ($msg) {
            $conn->send($msg);
            $conn->close();
        }, function ($e) {
            echo "Could not connect: {$e->getMessage()}\n";
        });
    }

    public function likingArticle(Request $request)
    {
        $user = $request->userId;
        $likedArticle = $request->artikelId;

        //firstly get what are the thing that is liked by the user
        $likedArticle_old = DB::table('ab_user')->where('id', '=', $user)->value('liked_article');

        $likedArticle_old = $likedArticle_old . '|' . $likedArticle . '|';
        $result = DB::table('ab_user')->where('id', $user)->update(['liked_article' => $likedArticle_old]);
    }
}
