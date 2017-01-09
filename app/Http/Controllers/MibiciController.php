<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mibici;
use DB;

class MibiciController extends Controller
{
	public function index()
    {
        return view('mibici.index');
    }

    public function getAll()
    { 
        //$mibicis = Mibici::orderBy('id','asc')->select('encodepath')->get(); 
        $mibicis = Mibici::all(); 
        //dd($mibicis);  
        return $mibicis;
    }
    
    public function create()
    {
        return view('mibici.create');
    }

    public function edit()
    {
        return view('mibici.edit');
    }

    public function destroy()
    {
        return view('mibici.destroy');
    }

/*    public function show()
    {
        $mibicis = Mibici::all();

        foreach ($mibicis as $mibici) 
        {
            echo $mibici->latitude;
        }
    }*/

    public function post(Request $request)
    {
        $mibici = new Mibici;
        $mibici->latitude = $request->markerFromLat; 
        $mibici->longitude = $request->markerFromLang;
        $mibici->description = $request->name;
        $mibici->type = "mibici";
        //$mibici->encodepath=$request->encodePath;
        //dd($mibici);
        $mibici->save();

        return redirect('/mibici');
    }
}