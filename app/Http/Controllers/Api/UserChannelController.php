<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ChannelResource;

class UserChannelController extends Controller
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
        $authUser = $this->authUser;
        $channels = $authUser->channels;

        return ChannelResource::collection($channels);
    }
}
