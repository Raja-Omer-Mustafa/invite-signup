<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, (new LoginRequest())->rules());
        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        if (!Auth::attempt($data)) {
            return response()->error(__('api.invalid_credentials'));
        }

        if (!is_null(Auth::user()->otp)) {
            return response()->error("Verify your OTP");
        }

        return response()->success(__('api.login_success_message'),
            [
                "accessToken" => $this->getPersonalAccessToken()->accessToken
            ]
        );
    }

    public function logout()
    {
        Auth::user()->token()->revoke();
        return response()->success(__('api.logout_message'));
    }

    public function getPersonalAccessToken()
    {
        if (request()->remember_me === 'true')
            Passport::personalAccessTokensExpireIn(now()->addDays(15));

        return Auth::user()->createToken(env('ACCESS_TOKEN_SECRET', 'Secret'));
    }
}
