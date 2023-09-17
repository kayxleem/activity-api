<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Activity;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Requests\API\UserLoginRequest;
use App\Http\Requests\API\UserRegisterRequest;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Usercontroller extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        //$user = User::create($request->validated());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json($user, Response::HTTP_CREATED);
        //return $user;
    }

    public function login(UserLoginRequest $request)
    {
        $user = User::whereEmail($request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json(['status_code' => Response::HTTP_UNAUTHORIZED, 'status' => 'error', 'message' => 'Invalid Credentials']);
        }
        $token = $user->createToken('api');
        return response(['token' => $token->plainTextToken]);
    }


}
