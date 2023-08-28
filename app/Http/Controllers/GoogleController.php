<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getGoogleSignInUrl()
    {
        try {
            $url = Socialite::driver('google')->with(["prompt" => "select_account"])->stateless()
                ->redirect()->getTargetUrl();

            return redirect($url);
            //with api response
            // return response()->json([
            //     'url' => $url,
            // ])->setStatusCode(Response::HTTP_OK);
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    public function loginCallback(Request $request)
    {
        try {
            $state = $request->input('state');

            parse_str($state, $result);
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('email', $googleUser->email)->first();
            if ($user) {
                Auth::login($user);
                return redirect()->route('dashboard');
            }
            $user = User::create(
                [
                    'email' => $googleUser->email,
                    'name' => $googleUser->name,
                    'google_id'=> $googleUser->id,
                    'password'=> Hash::make('123456'),
                ]
            );

            Auth::login($user);

            return redirect()->route('dashboard');

        } catch (\Exception $exception) {
            return response()->json([
                'status' => __('google sign in failed'),
                'error' => $exception,
                'message' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
