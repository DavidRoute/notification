<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Channel;
use App\Http\Resources\ChannelResource;

class ChannelController extends Controller
{
    public function index() 
    {
        $perPage = request('per_page', 15);

        $channels = Channel::isNotDefault()->paginate($perPage);

        return ChannelResource::collection($channels);
    }
}
