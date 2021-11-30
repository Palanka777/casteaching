<?php

use App\Models\Team;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;


if (!function_exists('create_default_user')) {

    function create_default_user()
    {
        $user = User::forceCreate([
            'name' => config('casteaching.default_user.name', 'Estudian'),
            'email' => config('casteaching.default_user.email', 'Falta el mail'),
            'password' => Hash::make(config('casteaching.default_user.password', 'admin'))

        ]);
        $user->superadmin=true;
        $user->save();

        add_personal_team($user);

    }

    if (!function_exists('create_default_profe_user')) {
        function create_default_profe_user()
        {
            $user = User::forceCreate([
                'name' => config('casteaching.default_user_profe.name', 'profe'),
                'email' => config('casteaching.default_user_profe.email', 'info@iesebre.com'),
                'password' => Hash::make(config('casteaching.default_user_profe.password'))

            ]);

            add_personal_team($user);

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

    if (!function_exists('create_regular_user')) {

        function create_regular_user(){
            $user = User::create([
                'name' => 'Pepe Pringao',
                'email' => 'info@Pepe.com',
                'password' => Hash::make('12345678')
            ]);

            add_personal_team($user);

            return $user;

        }

  }

    if (!function_exists('create_videomanager_user')) {

        function create_videomanager_user(){
            $user=User::create([
                'name'=>'VideosManager',
                'email'=>'info@VideosManager.com',
                'password'=>Hash::make('12345678'),
            ]);

            add_personal_team($user);

            Permission::create(['name' => 'videos_manage_index']);

            $user->givePermissionTo('videos_manage_index');

            return $user;

        }

    }

    if (!function_exists('add_personal_team')) {

        /**
         * @param $user
         */
        function add_personal_team($user): void
        {
            Team::forceCreate([
                'name' => $user->name . 's Team',
                'user_id' => $user->id,
                'personal_team' => true
            ]);
        }


        if (!function_exists('create_superadmin_user')) {

            function create_superadmin_user()
            {

                $user = User::create([
                    'name' => 'SuperAdmin',
                    'email' => 'info@SuperAdmin.com',
                    'password' => Hash::make('12345678')
                ]);
                $user->superadmin = true;
                $user->save();

                add_personal_team($user);


                return $user;

            }
        }

        if (!function_exists('define_gates')) {

            function define_gates()
            {

                Gate::before(function ($user, $ability) {
                    if ($user->isSuperAdmin())
                        return true;
                });

            }
        }

        if (!function_exists('create_permissions')) {
            function create_permissions()
            {
                Permission::firstOrCreate(['name' => 'videos_manage_index']);
            }

        }

    }
    if (!function_exists('createSampleTest')) {

        function createSampleVideos()
        {
            $video1 = Video::create([
                'title' => 'Video 1',
                'description' => '# Here description',
                'url' => 'https://youtube/w8j07_DBL_I',
                'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
                'previous' => null,
                'next' => null,
                'series_id' => 1
            ]);

            $video2 = Video::create([
                'title' => 'Video 2',
                'description' => '# Here description',
                'url' => 'https://youtube/w8j07_DBL_I',
                'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
                'previous' => null,
                'next' => null,
                'series_id' => 1
            ]);

            $video3 = Video::create([
                'title' => 'Video 3',
                'description' => '# Here description',
                'url' => 'https://youtube/w8j07_DBL_I',
                'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
                'previous' => null,
                'next' => null,
                'series_id' => 1
            ]);

            return [$video1, $video2, $video3];
        }
    }
}


