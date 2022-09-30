<?php

namespace App\Http\Controllers;
use App\Models\Shop;
use App\Models\Area;
use Illuminate\Http\Request;

class ShopController extends Controller
{
        public function index(Request $request)
    {
        $shops = Shop::all();
        $areas = Area::all();
        $area_id = $request->area_id;
        $param=[
            'shops'=>$shops,
            'areas'=>$areas,
            'area_id'=>$area_id
        ];
        return view('/index', $param);
    }
    
        public function detail(Request $request, $shop_id){
        $shop=Shop::find($shop_id);
        $param=[
        'shop_id'=>$shop_id,
        'shop'=>$shop
        ];
        return view('detail', $param);
    }

    public function search(Request $request){
        $area=$request->area;
        $genre=$request->genre;
        $name=$request->name;
            
        if(!empty($area)){
            $search=Shop::where('area', $area)->get();
        }        
        if(!empty($genre)){
            $search=Shop::where('genre', $genre)->get();
        }        
        if(!empty($name)){
            $search=Shop::where('name', 'like', "%{$name}%")->get();
        }        
        
        $param=[
            'area'=>$area,
            'genre'=>$genre,
            'shops'=>$search 
        ];
        return view('/index', $param);
    }
}