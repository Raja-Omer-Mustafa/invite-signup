<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $profileRequest = new ProfileRequest();
        $validator = Validator::make($request->all(), $profileRequest->rules(), $profileRequest->messages());
        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }
        $data = $request->all();
        $file = $request->file('avatar');
        $name = $file->getClientOriginalName();
        $file->move(public_path().'/images/', $name);
        $data['avatar'] = '/images/' . $name;
        if(User::find(Auth::user()->id)->fill($data)->update()) {
            return response()->success("Profile Updated");
        }
        return response()->error("Contact Support Team");
    }
}
