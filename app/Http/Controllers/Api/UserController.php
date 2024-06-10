<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\MockObject\Builder\Stub;

class UserController extends Controller
{
    //POST
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
       
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'password'=>'required|min:8'
       
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de datos.',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $user = User::create([
           
            'name' => $request->name,
            'email' => $request->email,
            'password'=>$request->password
        ]);
        if (!$user){
            $data = [
                'message' => 'Error al crear el usuario.',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
        
        $data = [
            'user' => $user,
            'status' => 201
        ];
        return response()->json($data, 201);
    }



}    
