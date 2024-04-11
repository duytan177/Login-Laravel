<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Product;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session as FacadesSession;

class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

        ]);

        return response()->json($user);
    }

    public function login(LoginRequest $request)
    {
        $request->session()->regenerate();

        $credentials = $request->only('email', 'password');
        $sites = $request->input('sites');

        $sessions =  Session::with("user")->get();
        foreach ($sessions as $session) {
            if ($session->user->email === $credentials['email'] && $session->sites === $sites) {
                return response()->json([
                    'error' => 'Account is logged in.Please log out first!',
                ], 409);
            }
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // get session information
            $sessionId = session()->getId();
            $minutes = config('session.lifetime') * 60;
            $cookie = Cookie::make('user_session', $sessionId, $minutes,"/login/user",null,true,false);
            return  response()->json([
                'success' => true,
                'user' =>   $user
            ], 200)->withCookie($cookie);
        }
            return response()->json([
                "success" => false,
                "error" => "Unauthorized"
            ], 401);
    }

    public function logout()
    {
        if (Session::find(session()->getId())->delete()) {
            session()->forget(session()->getId());
            Cookie::forget('user_session');
            return response()->json([
                "success" => true,
                'message' => "Logout Successfully"
            ], 200);
        }
        return response()->json([
            "success" => false,
            'message' => "Logout Failed"
        ], 400);
    }
}
