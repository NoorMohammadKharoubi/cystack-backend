<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $json_data = [];
        if ($request->q){
            $json_data = file_get_contents('https://crt.sh/?q=' . $request->q . '&output=json');
        }
        // if ($request->q){
        //     $json_data = file_get_contents('data.json');
        // }

        if ($json_data){
            $json_data = json_decode($json_data);
        }

        if ((boolean)json_decode(strtolower($request->expired_only))){
            $filtered = [];
            $current_time = time();
            foreach($json_data as $item){
                if (strtotime($item->not_after) < $current_time){
                    array_push($filtered, $item);
                }
            }
            $json_data = $filtered;
        }

        return Response::json($json_data, 200);
    }

}
