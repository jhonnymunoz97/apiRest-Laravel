<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return response([
            'status' => 'success',
            'messages' => 'Usuarios en el sistema',
            'data' => $user,
            'code' => 200,
        ]);
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->name =  $request->name;
        $user->password =  Hash::make($request->password);
        $user->email =  $request->email;
        $user->save();
        return response([
            'status' => 'success',
            'user' => $user,
            'code' => 200,
            'messages' => 'Usuario registrado con éxito'
        ]);
    }

    public function show($user)
    {
        $usuario = User::findOrFail($user);
        return response([
            'message' => 'Usuario encontrado',
            'data' => $usuario,
            'status' => 'success',
            'code' => 200
        ]);
    }

    public function update(Request $request,$id)
    {
        $user = User::findOrFail($id);
        $request['password'] = Hash::make($request->password);
        $user->update($request->all());
        return response([
            'message' => 'Usuario actualizado con éxito',
            'success' => 'success',
            'code' => 200
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response([
            'message' => 'Usuario eliminado con éxito',
            'success' => 'success',
            'code' => 200
        ]);
    }
}
