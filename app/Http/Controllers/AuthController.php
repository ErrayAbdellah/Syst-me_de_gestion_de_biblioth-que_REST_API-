<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Claims\JwtId;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register','reset','resetPassword']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|same:password',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json(['success' => 'register successfully'], 200);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
    public function me()
    {
        return response()->json(auth()->user());
    }

    public function resetPassword(){
        request()->validate(['email' => 'required|email|exists:users']);
        $token = Str::random(64);

        $email = request('email');

        DB::table('password_resets')->insert([
            'email' => $email, 
            'token' => $token, 
            'created_at' => Carbon::now()
        ]);
        
        Mail::send([], [], function($message) use($email,$token){
            $message->to($email);
            $message->subject('Reset Password');
            $message->text(
                "please click on the link below to reset your password. \n
                http://localhost:8000/api/password/reset?email=".$email."&token=".$token
                            );
        });

        return response()->json(['message'=> 'check your email']);
    }
    public function reset(){
        request()->validate([
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')
                            ->where([
                              'email' => request('email'), 
                              'token' => request('token')
                            ])
                            ->first();

        if(!$updatePassword){
            return response()->json(['error'=>'Invalid token!']);
        }

        $user = User::where('email', request('email'))
                    ->update(['password' => Hash::make(request('password'))]);

        DB::table('password_resets')->where(['email'=> request('email')])->delete();

        return response()->json(['message'=>'Your password has been changed!']);
    }
    public function updateProfile(Request $request){
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'new_email' => 'required|string|email|max:255|',
            'new_password' => 'required|string|min:6',
            'password_confirmation' => 'required|same:new_password',
        ]);
        $data =[
            'email'=>$request->new_email,
            'password'=>Hash::make($request->new_password),
        ];
        $user = JWTAuth::user();
        if(Auth::user()->email=== request('email') && Hash::check(request('password'), Auth::user()->password)){
            try{
                $user->where('id',$user->id)->update($data);
            }catch(Exception $e){
                return response()->json(['error'=>$e->getMessage()]);
            }
            return response()->json([
                'success'=>'user has been update',
                'data' => ['user' => User::find($user->id)]
            ], 201);
        }
            
            return response()->json(['error'=>'check your email or password']);
    }
}