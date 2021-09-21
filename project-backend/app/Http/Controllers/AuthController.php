<?php

namespace App\Http\Controllers;

//use App\Http\Requests\Register;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * @param Register $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $verification_token = Str::random(128);

        $photoName = $request->file('image')->getClientOriginalName();

        $path = $request->file('image')->store('public/images');


        $save = new Photo;

        $save->name = $photoName;
        $save->path = $path;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verification_token' => $verification_token,
            'path'
        ]);

        $this->sendEmail($user, $verification_token);

        return response()->json(['success' => 'user created'], 200);
    }

    /**
     * @param $user
     * @param $token
     */
    public function sendEmail($user, $token){
        Mail::send('mail.verify', ['user' => $user, 'token' => $token],
            function ($m) use ($user) {
                $m->to($user->email, $user->name)->subject('Please Verify your Email');
            });
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function verify(Request $request){

        $currentUser = User::query()->
        where('email', $request->get('email'))->
        where('verification_token', $request->get('token'))->first();

        if(Hash::check($request->get('password'), $currentUser['password'])){

            $currentUser->update([
                'verification_token'=> null,
                'email_verified_at'=> Carbon::now()->timestamp
            ]);
            return response()->json(['message' => 'You are registered']);
        }

        return response()->json(['message'=>"Wrong credentials"], 422);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token =  $user->createToken('Personal Access Token')->accessToken;

            return response()
                ->json([
                    'user' => $user,
                    'token' => $token,
                ]);
        } else {
            return response()->json(
                ['error' => 'invalid-credentials'], 422);
        }
    }

    public function current(){
        return Auth::user();
    }

    function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'successful-logout']);
    }
}
