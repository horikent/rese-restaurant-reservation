<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(LoginRequest $request)
    {
        return view('/admin', $managers);
	}

    public function manager(Request $request)
    {
        $areas=Area::all();
        $genres=Genre::all();
        $id=Auth::id();
        $managements=Shop::where('user_id', $id)->get();
        $param=[
            'areas'=>$areas,
            'genres'=>$genres,
            'id'=>$id,
            'managements'=> $managements
        ];
        return view('/manager', $param);
	}

    public function create(LoginRequest $request)
    {
        $name = $request ->name;
        $email = $request->email;
        $password = $request->password;
        $admin = $request->admin;
        $manager = $request->manager;
        $param = [
            'name'=> $name,
            'email' => $email,
            'password' => bcrypt($password),
            'admin' => $admin,
            'manager' => $manager
            ];    
        User::create($param);
        $admin=Auth::user()->admin;
        $manager=Auth::user()->manager;
        $param=[
            'admin'=>$admin,
            'manager'=>$manager
        ];
        return view('/complete', $param);
	}


    public function complete(Request $request)
    {
        $admin=Auth::user()->admin;
        $manager=Auth::user()->manager;
        $param=[
            'admin'=>$admin,
            'manager'=>$manager
        ];
        return view('/complete', $param);
	}

}
