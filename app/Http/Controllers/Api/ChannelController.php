<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Channel;
use App\Http\Resources\ChannelResource;
use ExpoSDK\Expo;

class ChannelController extends Controller
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

    public function index() 
    {
        $perPage = request('per_page', 15);

        $channels = Channel::isNotDefault()->paginate($perPage);

        return ChannelResource::collection($channels);
    }

    public function subscribe(Channel $channel) 
    {
        $authUser = $this->authUser;

        if ($authUser->channels->contains($channel)) {
            return response()->json(['message' => 'Already subscribed this channel.']);
        }

        $authUser->subscribe($channel);

        // Expo channel subscriptions
        $expo = Expo::driver('file');
        $recipients = [$authUser->device_token];

        $expo->subscribe($channel->name, $recipients);

        return response()->json(['message' => 'Successfully subscribed']);
    }

    public function unsubscribe(Channel $channel) 
    {
        $authUser = $this->authUser;

        if (! $authUser->channels->contains($channel)) {
            return response()->json(['message' => 'Channel did not subscribe yet.']);
        }
        
        $authUser->unsubscribe($channel);

        // Expo channel subscriptions
        $expo = Expo::driver('file');
        $recipients = [$authUser->device_token];

        $expo->unsubscribe($channel->name, $recipients);

        return response()->json(['message' => 'Successfully unsubscribed']);
    }
}
