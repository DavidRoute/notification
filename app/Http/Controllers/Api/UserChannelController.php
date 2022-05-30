<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ChannelResource;

class UserChannelController extends Controller
{
    public function index() 
    {
        $authUser = auth()->user();
        $channels = $authUser->channels;

        return ChannelResource::collection($channels);
    }
}
