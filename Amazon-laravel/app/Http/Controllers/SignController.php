<?php

namespace App\Http\Controllers;
use App\Mail\User\VerifyMail;
use App\Models\User;
use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\AdminLoginRequest;
use Illuminate\Support\Facades\Mail;

class SignController extends Controller
{
    public function register (RegisterRequest $request)
    {
        if ($request->password === $request->confirmation) {
            $str = rand();
            $token = md5($str);
            $userInfo = [
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'password' => $request->password,
                'token' => $token
            ];
            $user = User::create($userInfo);
            if ($user) {
                Auth::login($user);
                Mail::to($request->email)->send(new VerifyMail($token));

                $ids = $request->guestCardProducts;
                if ($ids) {
                    foreach ($ids as $id) {
                        $cartInfo = [
                            'user_id' => auth()->user()->id,
                            'product_id' => (int)$id['id'],
                            'product_count' => (int)$id['count'],
                        ];
                        Cart::create($cartInfo);
                    }
                }
                return response('success');
            }
        }
        $request_errors = new RegisterRequest();
        $messages = $request_errors->messages();
        return response()->json($messages);
    }

    public function login (LoginRequest $request)
    {
        $email = $request->email;
        $password =  $request->password;
        $credentials = [
            'email' => $email,
            'password' => $password
        ];
        $super_admin_check = User::where('email', $email)->first();
        if ($super_admin_check->role === 'user' && $super_admin_check->email_verified_at !== null) {
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $user->createToken('token')->plainTextToken;
                return response($token);
            }
        }
    }

    public function adminLogin (AdminLoginRequest $request)
    {
        $email = $request->loginAdminInfo['email'];
        $password =  $request->loginAdminInfo['password'];
        $credentials = [
            'email' => $email,
            'password' => $password
        ];
        $super_admin_check = User::where('email', $email)->first();
        if ($super_admin_check->role !== 'user') {
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $user->createToken('token')->plainTextToken;
                return response($token);
            }
        }
        return response('failure');
    }

    public function getAuthUserRole ()
    {
        $auth_user_role = User::where('id', auth()->user()->id)->first();
        return response()->json($auth_user_role->role);
    }

    public function logOut ()
    {
        return response('success');
    }

    public function verify ($token)
    {
        User::where('token', $token)->update(['email_verified_at' => Carbon::now()]);
        return response()->json('successfully verified');
    }
}
