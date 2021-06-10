<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invite;
use App\Http\Requests\InviteRequest;
use App\Http\Requests\SignupRequest;
use Validator;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class InviteController extends Controller
{
    public function store(Request $request, Invite $invite)
    {
        $inviteRequest = new InviteRequest();
        $rules = $inviteRequest->rules();
        $messages = $inviteRequest->messages();
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }
        
        $user = $invite->addNew($request);
        if($user) {
            return response()->success("Invitation Send Successfully", $user);
        }
        return response()->error("Contact Support Team");
    }

    public function process(Request $request, $token, Invite $invite)
    {
        $data = $request->all();
        $user = User::where('email', $invite->getEmail($token))->first();
        if ($user) {
            return response()->success("Verify OTP check your email",
                [
                    "accessToken" => $user->createToken(env('ACCESS_TOKEN_SECRET', 'Secret'))->accessToken
                ]);
        }
        $data['token'] = $token;
        $signupRequest = new SignupRequest();
        $rules = $signupRequest->rules();
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }
        $user = User::create([
            'name' => $request->username,
            'username' => $request->username,
            'email' => $invite->getEmail($token),
            'password' => $request->password,
        ]);
        
        if ($user) {
            return response()->success("Verify OTP check your email",
                [
                    "accessToken" => $user->createToken(env('ACCESS_TOKEN_SECRET', 'Secret'))->accessToken
                ]);
        }
    }

    public function otp($code)
    {
        $user = User::where(['email' => Auth::user()->email, 'otp' => $code]);
        if ($user->count() > 0) {
            $user->update(['otp' => null]);
            return response()->success("OTP verified Successfully");
        }
        return response()->error("Invalid OTP");
    }
}
