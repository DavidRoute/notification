<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NotificationRequest;
use App\Models\User;
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;

class NotificationController extends Controller
{
    public function index() 
    {
        $users = User::latest('id')->get();

        return view('welcome', compact('users'));
    }

    public function store(NotificationRequest $request) 
    {
        $data = $request->validated();

        $messageArr = [
            'title' => $request->title,
            'body' => $request->body,
        ];

        if ($request->data) {
            $messageArr['data'] = json_decode($request->data, true);
        }

        $message = (new ExpoMessage($messageArr));

        if ($request->notification_type == 1) {
            $user = User::findOrFail($request->user_id);
            $recipients = [$user->device_token];

            $response = (new Expo)->send($message)->to($recipients)->push();

            return $response->getData();
        } 
        else {
            $expo = Expo::driver('file');

            $channel = $request->channel;

            $response = $expo->send($message)->toChannel($channel)->push();

            return $response->getData();
        }

    }
}
