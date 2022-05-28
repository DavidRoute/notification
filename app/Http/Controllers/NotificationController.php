<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NotificationRequest;
use App\Models\User;
use App\Models\Channel;
use App\Models\Notification;
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;

class NotificationController extends Controller
{
    public function index() 
    {
        $users = User::latest('id')->get();
        $channels = Channel::all();

        return view('welcome', compact('users', 'channels'));
    }

    public function store(NotificationRequest $request) 
    {
        $data = $request->validated();

        Notification::create([
            'title' => $request->title,
            'body'  => $request->body,
            'data'  => $request->data
        ]);

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

            $channel = Channel::findOrFail($request->channel_id);

            $response = $expo->send($message)->toChannel($channel->name)->push();

            return $response->getData();
        }

    }
}
