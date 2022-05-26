<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;

class NotificationController extends Controller
{
    public function index() 
    {
        $users = User::all();

        return view('welcome', compact('users'));
    }

    public function store(Request $request) 
    {
        $message = (new ExpoMessage([
            'title' => 'initial title',
            'body' => 'initial body',
            'data' => [
                'link' => 'https://res.cloudinary.com/demo/image/upload/sample.gif'
            ]
        ]));

        // $recipients = [
        //     'ExponentPushToken[ImnMOtO5oKeTjSQW0nfNNa]',
        // ];

        $expo = Expo::driver('file');
        // name your channel anything you'd like
        $channel = 'covid';
        // the channel will be created automatically if it doesn't already exist
        // $expo->subscribe($channel, $recipients);

        $response = $expo->send($message)->toChannel($channel)->push();

        dd($response);
        // $response = (new Expo)->send($message)->to($defaultRecipients)->push();

    }
}
