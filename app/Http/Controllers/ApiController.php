<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;


class ApiController extends Controller
{

    public function create()
    {
        return view('index');
    }

    public function store(Request $request)
    {
        $cep = $request->input('cep');
        
        $client = new Client();
         $apiUrl = 'viacep.com.br/ws/'. $cep . '/json';
         try {
             $response = $client->request('GET', $apiUrl);

             
             if ($response->getStatusCode() === 200) {
                 $data = json_decode($response->getBody(), true);
                 
                
                return view('cep', $data);
            
             } else {
                
                 return response()->json(['error' => 'Falha ao acessar a API'], $response->getStatusCode());
             }
         } catch (\Exception $e) {
             
             return response()->json(['error' => $e->getMessage()], 500);
         }
     }
        
    }