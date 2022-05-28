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
        $defaultChannels = [
            'All',
            'Android',
            'IOS'
        ];

        $channels = [
            'Covid',
            'Life',
            'Care',
            'Car',
        ];

        foreach ($defaultChannels as $key => $value) {
            Channel::create([
                'name'       => $value,
                'is_default' => true
            ]);
        }

        foreach ($channels as $key => $value) {
            Channel::create([
                'name'       => $value,
            ]);
        }
    }
}
