<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appversion;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    //

    public function appVersion(Request $request){

        $type=$request->type;
        $version=$request->version;
        if($type!="iOS" && $type!="Android"){
            return \response()->json(['message' => "invalid device type"], 422);
        }
        $data=Appversion::select('applink')->where('platform',$request->type)->first();
        $minversion=$data->minversion;
        $currentversion=$data->version;
        if($minversion>$version){
            $data->status=1;
            return \response()->json(['data' => $data], 200);
        }else if($currentversion>$version){
            $data->status=2;
            return \response()->json(['data' => $data], 200);
        }else{
            $data->status=0;
            return \response()->json(['data' => $data], 200);
        }

    }
}
