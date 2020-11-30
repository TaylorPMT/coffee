<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\User;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    public function index(){
        $countdonhang=OrderModel::get()->count();
        $countProduct=ProductModel::get()->count();
        $countUser=User::get()->count();
        return view('BackEnd.dashboard.index',compact('countdonhang','countProduct','countUser'));
    }
    public function countOrderMonth(Request $request)
    {
        if($request->ajax())
        {
           $monthYear = $request->month;
            $count=OrderModel::whereMonth('created_at',\Carbon\Carbon::parse($monthYear)->format('m'))->
            whereYear('created_at',\Carbon\Carbon::parse($monthYear)->format('Y'))->get()->count();
            return response()->json($count);

        }
    }
 }
