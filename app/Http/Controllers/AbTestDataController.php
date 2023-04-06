<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AbTestData;
class AbTestDataController extends Controller
{
    //
    public function AbTestDataAusgeben(){
        $datas = AbTestData::all();
        foreach ($datas as $data){
            echo $data->id . '=>'. $data->ab_testname . '<br>';
        }
    }
}
