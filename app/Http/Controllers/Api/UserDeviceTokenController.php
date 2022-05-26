<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use ExpoSDK\Expo;

class UserDeviceTokenController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->authUser = auth()->loginUsingId(11);

            return $next($request);
        });
    }

    public function store(Request $request) 
    {
        $request->validate([
            'device_token' => ['required', 'string'],
            'os_type' => [ 'required', Rule::in(['android', 'ios']) ]
        ]);

        $authUser = $this->authUser;
        $authUser->device_token = $request->device_token;
        $authUser->save();

        $expo = Expo::driver('file');

        $recipients = [$authUser->device_token];

        // the channel will be created automatically if it doesn't already exist
        $expo->subscribe('all', $recipients);
        $expo->subscribe($request->os_type, $recipients);

        return response()->json(['message' => 'Success']);
    }
}
