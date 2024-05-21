<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $client = new Client();
        $response = $client->post(env('SUPABASE_URL') . '/auth/v1/token', [
            'json' => [
                'email' => $request->email,
                'password' => $request->password,
            ],
            'headers' => [
                'apikey' => env('SUPABASE_KEY'),
                'Content-Type' => 'application/json',
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $body = json_decode($response->getBody(), true);
            // 認証トークンをセッションに保存するなどの処理
            // ここでユーザーをログイン状態にする必要があります
            // 例: Auth::loginUsingId($user->id);
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Login failed.'])->withInput();
    }
}
