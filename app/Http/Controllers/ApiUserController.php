<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return response()->json($request->all());
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'messages' => $validator->errors(),
            ]);
        }

        $user_data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ];

        $user = User::create($user_data);

        return response()->json([
            'status' => 1,
            'messages' => 'User registered successfully',
            'user' => $user,
        ]);
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
        //
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            $user = User::where('email', $request->email)->first();

            if($user){
                if (!Hash::check($request->password, $user->password, [])) {
                    return response()->json([
                        'status' => 0,
                        'messages' => 'Invalid email or password.',
                    ]);
                }
            }else{
                return response()->json([
                    'status' => 0,
                    'messages' => 'Invalid email or password.',
                ]);
            }

            $user = User::where('email', $request->email)->first();
            $user_info = $user->first();
            $token = $user_info->createToken('mobile-token')->plainTextToken;

            return response()->json([
                'status' => 1,
                'token' => $token,
                'user' => compact('user'),
            ]);
        }
    }
}
