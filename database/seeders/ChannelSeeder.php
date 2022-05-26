<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Channel;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $channels = [
            'all',
            'android',
            'ios'
        ];

        foreach ($channels as $key => $value) {
            Channel::create(['name' => $value]);
        }
    }
}
