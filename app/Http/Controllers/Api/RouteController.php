<?php

namespace App\Http\Controllers\Api;

use App\DefaultRoute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Dijkstra\Graph;

class RouteController extends Controller
{
    public function bestRoute(Request $request){

        $routeData = $request->all();
        $origin = ""; $destiny = ""; $autonomy = 0; $literValue = 0;

        try {
            $routeData = $request->all();
            $origin = $routeData["origin"];
            $destiny = $routeData["destiny"];
            $autonomy = $routeData["autonomy"];
            $literValue = $routeData["literValue"];

		} catch (\Exception $e) {
            $data = ['data' => ['msg' => $e->getMessage(), 'code' => 500]];
            return response()->json($data, 500);
		}

        $DefaultRoutes = $this->populateDefaultRoute();
        
        $errorOrigin = true;
        $errorDestiny = true;

        $literValue = str_replace(",", ".", $literValue);

        if(!is_numeric($autonomy)){
            $data = ['data' => ['msg' => 'Autonomy must be numeric', 'code' => 400]];
            return response()->json($data, 400);
        }

        if(!is_numeric($literValue)){
            $data = ['data' => ['msg' => 'Value of fuel must be numeric', 'code' => 400]];
            return response()->json($data, 400);
        }

        $graph = Graph::create();

        foreach($DefaultRoutes as $route){
            $graph->add($route["origin"], $route["destiny"], $route["distance"]);

            if($origin == $route["origin"]){
                $errorOrigin = false;
            }

            if($destiny == $route["destiny"]){
                $errorDestiny = false;
            }
        }

        if($errorOrigin){
            $data = ['data' => ['msg' => 'Origin does not exist', 'code' => 400]];
            return response()->json($data, 400);
        }
        
        if($errorDestiny){
            $data = ['data' => ['msg' => 'Destiny does not exist', 'code' => 400]];
            return response()->json($data, 400);
        }

        $route = $graph->search($origin, $destiny);
        $cost  = $graph->cost($route);

        $moneyCost = ($cost / $autonomy) * $literValue;

        $data = ['data' => ['best_route' => $route, 'cost' => $moneyCost]];
        return response()->json($data, 200);
    }


    protected function populateDefaultRoute(){
        $jsonDefaultRoutes = file_get_contents("../database/DefaultRoutes.json");
        $DefaultRoutes = json_decode($jsonDefaultRoutes, true);
        return $DefaultRoutes;
    }
}
