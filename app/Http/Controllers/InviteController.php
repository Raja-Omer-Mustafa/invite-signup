<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invite;
use App\Http\Requests\InviteRequest;
use Validator;

class InviteController extends Controller
{
    public function store(Request $request, Invite $invite)
    {
        $rules = (new InviteRequest)->rules();
        $validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
            return response()->error($validator->errors()->first());
		}
        
        $user = $invite->addNew($request);
        if($user) {
            return response()->success("Invitation Send Successfully", $user);
        }
        return response()->error("Contact Support Team");
    }
}
