<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use ExpoSDK\Expo;

class UserDeviceTokenController extends Controller
{
    public function store(Request $request) 
    {
        $request->validate([
            'device_token' => ['required', 'string'],
            'os_type' => [ 'required', Rule::in(['Android', 'IOS']) ]
        ]);

        $authUser = auth()->user();
        $authUser->device_token = $request->device_token;
        $authUser->os_type = $request->os_type;
        $authUser->save();

        $expo = Expo::driver('file');

        $recipients = [$authUser->device_token];

        // the channel will be created automatically if it doesn't already exist
        $expo->subscribe('All', $recipients);
        $expo->subscribe($request->os_type, $recipients);

        return response()->json(['message' => 'Success']);
    }
}
