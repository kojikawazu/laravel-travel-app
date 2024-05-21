<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Supabase用サインアップコントローラー
 */
class RegisterController extends Controller
{

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        // SupabaseClientでデータベースにユーザーを登録する
        $client = new Client();
        $response = $client->post(env('SUPABASE_URL') . '/auth/v1/signup', [
            'json' => [
                'email' => $request->email,
                'password' => $request->password,
            ],
            'headers' => [
                'apikey' => env('SUPABASE_KEY'),
                'Content-Type' => 'application/json',
            ]
        ]);

        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        \Log::info('Supabase response status code: ' . $statusCode);
        \Log::info('Supabase response body: ' . print_r($responseBody, true));

        if ($response->getStatusCode() == 200) {
            // Supabaseの登録が成功した場合、ローカルのユーザーデータベースにも保存する
            $user = \App\Models\User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            ]);

            // ログインさせる
            \Illuminate\Support\Facades\Auth::login($user);

            return redirect()
                ->route('home')
                ->with('status', 'Registration successful!');
        }

        // 登録失敗処理
        return back()
            ->withErrors(['email' => 'Registration failed.'])
            ->withInput();
    }
}