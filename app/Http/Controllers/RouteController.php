<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bus;
use App\Rel_concessionaire;
use App\Route;
use App\Node;
use App\Repositories\RouteRepository;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Collection;
class RouteController extends Controller
{
     /**
     * The route repository instance.
     *
     * @var rutasRepository
     */
    protected $rutasDAO;

    /**
     * Create a new controller instance.
     *
     * @param  CicloviaRepository  $ciclovias
     * @return void
     */
    public function __construct(RouteRepository $rutas, Request $request)
    {
        //Cuando la petición es desde API
        if($request->route()){
            if($request->route()->getPrefix()=="api"){
                $this->middleware('jwt.auth',['except'=>['getAllJson','getNearRoutes']]);
            }
            else{#Peticion desde web
                $this->middleware('auth',['except' =>[
                    'search',
                    'getNearRoutes']]);
                $this->middleware('admin',['except' => [
                    'show',
                    'getAllJson',
                    'search',
                    'getNearRoutes'
                    ]]);
            }
        }
        $this->rutasDAO = $rutas;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('routes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('routes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($this->rutasDAO->createRoute($request))
            flash('Ciclovia creada con exito','success');
        else
            flash('Error al intentar crear ciclovia','danger');
        return redirect('/route');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->rutasDAO->deleteRoute($id))
            flash('Ruta eliminada con exito', 'success');
        else
            flash('Error al intentar eliminar ruta','danger');
        return redirect('/route');
    }

    public function getBuses(Request $request, $id)
    {
        if($request->ajax()){
            $buses=Bus::where('concessionaire_id',$id)->get();
            return response()->json($buses);
        }
    }
    public function getConcesionarios(Request $request, $id)
    {
        if($request->ajax()){
            $buses=Rel_concessionaire::where('route_id',$id)->get();
            $user_response=[];
            foreach ($buses as $key=> $user)
            {

                $user_response[$key]['id']=$user->user->id;
                $user_response[$key]['name']=$user->user->name;
                $user_response[$key]['email']=$user->user->email;
                $user_response[$key]['role']=$user->user->role->description;
                $user_response[$key]['color']=$user->user->getColor();
            }
            return response()->json($user_response);
        }
    }
    /**
    * Show all bikeways
    * @return json
    */
    public function getAllJson($type=null)
    {
        $ciclovias = $this->rutasDAO->getAllRoutes($type);
        return $ciclovias;
    }

    /**
     * Search for a specific route 
     * @param String $search
     * @return json $route
    */
    public function search(Request $request){
        $routes=Route::where('name','LIKE','%'.$request->origin.'%')->get();
        $route_response=new Collection;
        foreach ($routes as $key=> $route)
        {
            $route_array=[];
            $nodos = new Collection;
            $rel_routes=$route->rel_route;
            foreach ($rel_routes as $key => $rel_route) {
                $nodo=[];
                $nodo['longitude']=$rel_route->start_node->longitude;
                $nodo['latitude']=$rel_route->start_node->latitude;
                $nodos->push($nodo);
            }
            $route_array['id']=$route->id;
            $route_array['name']=$route->name;
            $route_array['type']=$route->type;
            $route_array['type_read']=trans('route.'.$route->type);
            //$route_array['name']=$route->name;
            $route_array['paths']=$route->paths;
            $route_array['color']=$route->color;
            $route_array['nodos']=$nodos;
            $route_response->push($route_array);
        }
        $response['data']=$route_response;
        return json_encode($response);
    }

    /**
    * Get near routes
    * @return json
    */
    public function getNearRoutes(Request $request)
    {
        $response = $this->rutasDAO->nearRoutes($request->originNear_lat, $request->originNear_lng, $request->rango);
        return json_encode($response);
        
    }
}
