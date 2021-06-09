<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invite;
use App\Http\Requests\InviteRequest;
use Validator;
use Illuminate\Support\Str;
use App\Models\User;

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
        $data['token'] = $token;
        $rules = [ // can define separate request for signup rules
            'username' => [
                'required',
                'string',
                'min:4',
                'max:20',
                'unique:users,name',
                'alpha_dash',
            ],
            'password' => [
                'required', 
                'string',
                'min:8',
                'confirmed'
            ],
            'token' => [
                'exists:invites'
            ]
        ];
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
            return response()->success("Verify OTP check your email");
        }
    }

    public function otp($code)
    {
        dd($code);
    }
}
