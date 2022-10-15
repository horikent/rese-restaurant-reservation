<?php

namespace App\Http\Controllers;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ShopController extends Controller
{


public function index(Request $request)
    {
        $id=Auth::id();
        $shops=Shop::all();
        $areas=Area::all();
        $genres=Genre::all();
        $shop_id=Favorite::with('shop_id');
        $favorites=Favorite::all()->first();
    
        $param=[
            'id'=>$id,
            'shops'=>$shops,
            'areas'=>$areas,
            'genres'=>$genres,
            'shop_id'=>$shop_id,
            'favorites'=>$favorites
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
        $area_id=$request->area_id;
        $genre_id=$request->genre_id;
        $name=$request->name;
        $shop_id=Favorite::with('shop_id');
        $favorites=Favorite::all()->first();

        if(!empty($area_id)){
            $search=Shop::where('area_id', $area_id)->get();
        }        
        if(!empty($genre_id)){
            $search=Shop::where('genre_id', $genre_id)->get();
        }        
        if(!empty($name)){
            $search=Shop::where('name', 'like', "%{$name}%")->get();
        }        
        if(!empty($area_id)&&($genre_id)){
            $search=Shop::where('area_id', $area_id)->where('genre_id', $genre_id)->get();
        }  
        if(!empty($area_id)&&($name)){
            $search=Shop::where('area_id', $area_id)->where('name', 'like', "%{$name}%")->get();
        }  
        if(!empty($$genre_id)&&($name)){
            $search=Shop::where('genre_id', $genre_id)->where('name', 'like', "%{$name}%")->get();
        }  
        if(!empty($area_id)&&($genre_id)&&($name)){
            $search=Shop::where('area_id', $area_id)->where('genre_id', $genre_id)->where('name', 'like', "%{$name}%")->get();
        }     
        if((empty($area_id))&&(empty($genre_id))&&(empty($name))){
            $search=Shop::all();
        }           

        $param=[
            'area_id'=>$area_id,
            'genre_id'=>$genre_id,
            'shops'=>$search,
            'shop_id'=>$shop_id,
            'favorites'=>$favorites
        ];
        return view('/index', $param);
    }

    public function thanks(Request $request){

        return view('/thanks');
    }
}