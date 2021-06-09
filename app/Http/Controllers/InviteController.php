<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invite;
use Illuminate\Support\Str;

class InviteController extends Controller
{
    public function store(Request $request)
    {
    	Invite::create([
    		'token' => Str::random(10),
        	'name' => 'abc',
        	'email' => 'abc@gmail.com'
        ]);
    }
}
