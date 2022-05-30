<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Channel;
use App\Http\Resources\ChannelResource;
use ExpoSDK\Expo;

class ChannelController extends Controller
{
    public function index() 
    {
        $perPage = request('per_page', 15);

        $channels = Channel::isNotDefault()->paginate($perPage);

        return ChannelResource::collection($channels);
    }

    public function subscribe(Channel $channel) 
    {
        $authUser = auth()->user();

        if ($authUser->channels->contains($channel)) {
            return response()->json(['message' => 'Already subscribed this channel.']);
        }

        $authUser->subscribe($channel);

        // Expo specific channel subscriptions
        $expo = Expo::driver('file');
        $recipients = [$authUser->device_token];

        $expo->subscribe($channel->name, $recipients);

        return response()->json(['message' => 'Successfully subscribed']);
    }

    public function unsubscribe(Channel $channel) 
    {
        $authUser = auth()->user();

        if (! $authUser->channels->contains($channel)) {
            return response()->json(['message' => 'Channel did not subscribe yet.']);
        }
        
        $authUser->unsubscribe($channel);

        // Expo specific channel unsubscriptions
        $expo = Expo::driver('file');
        $recipients = [$authUser->device_token];

        $expo->unsubscribe($channel->name, $recipients);

        return response()->json(['message' => 'Successfully unsubscribed']);
    }

    public function allUnsubscribe() 
    {
        $authUser = auth()->user();

        $expo = Expo::driver('file');
        $recipients = [$authUser->device_token];

        $authUser->allUnsubscribe();

        // Expo all channel unsubscriptions
        $expo->subscribe('All', $recipients);
        $expo->subscribe($authUser->os_type, $recipients);
        foreach ($authUser->channels as $channel) {
            $expo->unsubscribe($channel->name, $recipients);
        }

        return response()->json(['message' => 'Successfully unsubscribed']);
    }

    public function resubscribe() 
    {
        $authUser = auth()->user();

        $expo = Expo::driver('file');
        $recipients = [$authUser->device_token];

        $authUser->resubscribe();

        // Expo channel resubscriptions
        $expo->subscribe('All', $recipients);
        $expo->subscribe($authUser->os_type, $recipients);
        foreach ($authUser->channels as $channel) {
            $expo->subscribe($channel->name, $recipients);
        }

        return response()->json(['message' => 'Successfully resubscribed']);
    }
}
