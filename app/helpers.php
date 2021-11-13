<?php

use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

if (!function_exists('create_default_user')) {

    function create_default_user()
    {
       return User::create([
            'name' => config('casteaching.default_user.name', 'Estudian'),
            'email' => config('casteaching.default_user.email', 'Falta el mail'),
            'password' => Hash::make(config('casteaching.default_user.password', 'admin'))

        ]);
    }
    if (!function_exists('create_default_profe_user')) {
        function create_default_profe_user()
        {
           return User::create([
                'name' => config('casteaching.default_user_profe.name', 'profe'),
                'email' => config('casteaching.default_user_profe.email', 'info@iesebre.com'),
                'password' => Hash::make(config('casteaching.default_user_profe.password'))

            ]);
        }
    }
    if (!function_exists('create_default_video')) {
        function create_default_video()
        {
           return Video::create([
                'title' => 'Ubuntu 101',
                'description' => '# Here description',
                'url' => 'https://youtube/w8j07_DBL_I',
                'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
                'previous' => null,
                'next' => null,
                'series_id' => 1
            ]);
        }
    }

}