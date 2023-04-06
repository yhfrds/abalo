<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\artikelInsert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ArticlesController extends Controller
{
    public function showArticle_M1A10(Request $request){

        $variable = strtolower($request->search);
        $result = DB::table('ab_article')
            ->whereRaw("lower(ab_name) like '%".$variable."%'" )
            ->get();

        return view('Articles',['table' => $result]);
    }

    public function addNewArticle_M2A9(Request $request){
        $rules = [
            'name' => 'required|string',
            'price' => 'required|integer|min:1',
            'description' => 'required|string'
        ];

        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()]);
        }
        else{
            $values = [
                'ab_name'=>$request->name,
                'ab_price'=>$request->price,
                'ab_description'=>$request->description,
                'ab_creator_id' => 1,
                'ab_createdate' => Carbon::now()->toDateTimeString()
            ];

            $query = DB::table('ab_article')->insert($values);
            if ($query) {
                return response()->json(['status'=>1, 'msg'=>'Saved successfully']);
            }
        }
    }

    public function likingArticle(Request $request){
        $user = $request->userId;
        $likedArticle = $request->artikelId;

        //firstly get what are the thing that is liked by the user
//        $result = DB::select('select * from ab_user where id=?',[1]);
//        return view('Articles',['hasil' => $result]);
    }
}
