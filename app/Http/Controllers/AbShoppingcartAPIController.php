<?php

namespace App\Http\Controllers;

use App\Models\AbShoppingcartItem;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
//dont forget to add the models
use App\Models\AbShoppingcart;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class AbShoppingcartAPIController extends Controller
{
    //
    function addShoppingcart (Request $request){
        $abShoppingcart = new AbShoppingcart;
        /*$abShoppingcart->id = $request->ab_creator_id;*/
        $abShoppingcart->ab_creator_id = $request->ab_creator_id;
        $abShoppingcart->ab_createdate = $request->ab_createdate;

        //check if shoppingcart with a creator id already exist
        $shoppingcart_doesnt_Exists = DB::table('ab_shoppingcart')->select('id')->where('ab_creator_id', $request->ab_creator_id)->doesntExist();


        if($shoppingcart_doesnt_Exists){
            //then create the shoppingcart
            $resultSC = $abShoppingcart->save();
        }else
            $resultSC = false;

        $get_Shoppingcart_Id = DB::table('ab_shoppingcart')->select('id')
            ->where('ab_creator_id', $request->ab_creator_id)
            ->value('id');

        $cookie_name = "shoppingcart_id";
        $cookie_value = $get_Shoppingcart_Id;
        setcookie($cookie_name, $cookie_value, time() + 120, "/"); // 86400 = 1 day

        $abShoppingcartItem = new AbShoppingcartItem;
        $abShoppingcartItem->ab_shoppingcart_id = $get_Shoppingcart_Id;
        $abShoppingcartItem->ab_article_id = $request->ab_article_id;
        $abShoppingcartItem->ab_createdate = $request->ab_createdate;

        $resultSCItem = $abShoppingcartItem->save();

        if($resultSC && $resultSCItem){
            return ["ResultSC & ResultSCItem"=>"Data has been saved", "filter table"=>$get_Shoppingcart_Id, "shoppingcartexist"=>"$shoppingcart_doesnt_Exists"];
        }else if($resultSC && !$resultSCItem){
            return ["ResultSCItem"=>"Operation failed"];
        }else if(!$resultSC && $resultSCItem){
            return ["ResultSC"=>"Operation failed"];
        }else{
            return ["Result"=>"Operation failed"];
        }
    }

    function deleteItemInShoppingcart($shoppingcartId, $articleId){
        $result = AbShoppingcartItem::where('ab_article_id',$articleId)->where('ab_shoppingcart_id',$shoppingcartId)->delete(); //with ...->get() can't delete but can only see or check what was printed
        if($result){
            return ["Result"=> "Article Id : ".$articleId. " in shoppingcart ".$shoppingcartId." is successfully deleted",
                "article_in_warenkorb enthält: "=>$result];
        }else{
            return ["Result"=> "FAILED! Article Id : ".$articleId. " in shoppingcart ".$shoppingcartId." is NOT deleted",
                "article_in_warenkorb enthält: "=>$result];
        }

    }
}
