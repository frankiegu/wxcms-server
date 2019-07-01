<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Http\Resources\AdResource;
use Carbon\Carbon;

class AdController extends Controller
{


    public function index(Request $request){
        $data = Ad::where('appid','=',$request->get('appid'))->where('state','=',1)
        ->where('start_at','>',Carbon::now())
        ->where('end_at','<',Carbon::now())
        ->orderBy('priority','desc')
        ->simplePaginate(50);
        $articles = AdResource::collection($data);
        return response()->json($articles);
    }

}
