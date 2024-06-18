<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'id' => $user->id,
        
        ];
        return response()->json($data, 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'failure']);
        }
    }
}    



    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials)) {
    //         $user = Auth::user();
    //         $token = $user->createToken('Personal Access Token')->plainTextToken;

    //         return response()->json(['token' => $token], 200);
    //     } else {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }
    // }


