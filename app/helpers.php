<?php

use App\Models\Serie;
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
            'name' => config('casteaching.default_user.name', 'David Pont Lopez'),
            'email' => config('casteaching.default_user.email', 'dpont@iesebre.com'),
            'password' => Hash::make(config('casteaching.default_user.password', '12345678'))

        ]);
        $user->superadmin = true;
        $user->save();

        add_personal_team($user);

    }

    if (!function_exists('create_default_profe_user')) {
        function create_default_profe_user()
        {
            $user = User::forceCreate([
                'name' => config('casteaching.default_user_profe.name', 'Sergi Tur Badenas'),
                'email' => config('casteaching.default_user_profe.email', 'sergiturbadenas@gmail.com'),
                'password' => Hash::make(config('casteaching.default_user_profe.password', 12345678))

            ]);

            $user->superadmin = true;
            $user->save();

            add_personal_team($user);

        }
    }
    if (!function_exists('create_default_video')) {
        function create_default_video()
        {
            return Video::create([
                'title' => 'Ubuntu 101',
                'description' => '# Here description',
                'url' => 'https://www.youtube.com/embed/EjYOBTK8NMQ?list=PLyasg1A0hpk07HA0VCApd4AGd3Xm45LQv',
                'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
                'previous' => null,
                'next' => null,
                'serie_id' => 1
            ]);
        }
    }

    if (!function_exists('create_regular_user')) {

        function create_regular_user()
        {
            $user = User::create([
                'name' => 'Pepe Pringao',
                'email' => 'pringao@casteaching.com',
                'password' => Hash::make('12345678')
            ]);

            add_personal_team($user);

            return $user;

        }

    }

    if (!function_exists('create_videomanager_user')) {

        function create_videomanager_user()
        {
            $user = User::create([
                'name' => 'VideosManager',
                'email' => 'videosmanager@casteaching.com',
                'password' => Hash::make('12345678'),
            ]);
            Permission::create(['name' => 'videos_manage_index']);
            Permission::create(['name' => 'videos_manage_create']);
            Permission::create(['name' => 'videos_manage_delete']);
            Permission::create(['name' => 'videos_manage_store']);
            Permission::create(['name' => 'videos_manage_edit']);
            Permission::create(['name' => 'videos_manage_update']);

            $user->givePermissionTo('videos_manage_index');
            $user->givePermissionTo('videos_manage_create');
            $user->givePermissionTo('videos_manage_delete');
            $user->givePermissionTo('videos_manage_store');
            $user->givePermissionTo('videos_manage_edit');
            $user->givePermissionTo('videos_manage_update');

            add_personal_team($user);
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
                    'email' => 'superadmin@casteaching.com',
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
                Permission::firstOrCreate(['name' => 'videos_manage_create']);
                Permission::firstOrCreate(['name' => 'videos_manage_delete']);
                Permission::firstOrCreate(['name' => 'videos_manage_store']);
                Permission::firstOrCreate(['name' => 'videos_manage_edit']);
                Permission::firstOrCreate(['name' => 'videos_manage_update']);


                Permission::firstOrCreate(['name' => 'users_manage_index']);
                Permission::firstOrCreate(['name' => 'users_manage_create']);
                Permission::firstOrCreate(['name' => 'users_manage_delete']);
                Permission::firstOrCreate(['name' => 'users_manage_store']);
                Permission::firstOrCreate(['name' => 'users_manage_edit']);
                Permission::firstOrCreate(['name' => 'users_manage_update']);

            }

        }

    }
    if (!function_exists('createSampleTest')) {

        function createSampleVideos()
        {
            $video1 = Video::create([
                'title' => 'Video 1',
                'description' => '# Here description',
                'url' => 'https://www.youtube.com/embed/DzZKgGM7swk?list=PLyasg1A0hpk07HA0VCApd4AGd3Xm45LQv',
                'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
                'previous' => null,
                'next' => null,
                'serie_id' => 1
            ]);

            $video2 = Video::create([
                'title' => 'Video 2',
                'description' => '# Here description',
                'url' => 'https://www.youtube.com/embed/zyABmm6Dw64?list=PLyasg1A0hpk07HA0VCApd4AGd3Xm45LQv',
                'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
                'previous' => null,
                'next' => null,
                'serie_id' => 1
            ]);

            $video3 = Video::create([
                'title' => 'Video 3',
                'description' => '# Here description',
                'url' => 'https://www.youtube.com/embed/0F_jX4-T4C4',
                'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
                'previous' => null,
                'next' => null,
                'serie_id' => 1
            ]);

            return [$video1, $video2, $video3];
        }
    }

    if (!function_exists('create_user_manager_user')) {
        function create_user_manager_user()
        {
            $user = User::create([
                'name' => 'UserManager',
                'email' => 'usersmanager@casteaching.com',
                'password' => Hash::make('12345678')
            ]);


            Permission::create(['name' => 'users_manage_index']);
            Permission::create(['name' => 'users_manage_create']);
            Permission::create(['name' => 'users_manage_store']);
            Permission::create(['name' => 'users_manage_destroy']);
            Permission::create(['name' => 'users_manage_edit']);
            Permission::create(['name' => 'users_manage_update']);

            $user->givePermissionTo('users_manage_index');
            $user->givePermissionTo('users_manage_create');
            $user->givePermissionTo('users_manage_store');
            $user->givePermissionTo('users_manage_destroy');
            $user->givePermissionTo('users_manage_edit');
            $user->givePermissionTo('users_manage_update');

            add_personal_team($user);
            return $user;
        }
    }

    if (!function_exists('create_sample_users')) {
        function create_sample_users()
        {
            $user1 = User::create([
                'name' => 'User 1',
                'email' => 'user1@prova.com',
                'password' => Hash::make('12345678')
            ]);
            $user2 = User::create([
                'name' => 'User 2',
                'email' => 'user2@prova.com',
                'password' => Hash::make('12345678')
            ]);
            $user3 = User::create([
                'name' => 'User 3',
                'email' => 'user3@prova.com',
                'password' => Hash::make('12345678')
            ]);

            return [$user1, $user2, $user3];
        }
    }


    class DomainObject implements ArrayAccess, JsonSerializable
    {
        private $data = [];

        /**
         * DomainObject constructor.
         */
        public function __construct($data)
        {
            $this->data = $data;
        }

        public function __get($name)
        {
            if (isset($this->data[$name])) {
                return $this->data[$name];
            }
        }

        public function __set($name, $value)
        {
            $this->data[$name] = $value;
        }

        public function offsetExists($offset)
        {
            return array_key_exists($offset, $this->data);
        }

        public function offsetSet($offset, $value)
        {
            $this->data[$offset] = $value;
        }

        public function offsetGet($offset)
        {
            return $this->data[$offset];
        }

        public function offsetUnset($offset)
        {
            unset($this->data[$offset]);
        }

        public function __toString()
        {
            return (string)collect($this->data);
        }

        /**
         * Specify data which should be serialized to JSON.
         *
         * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
         * @return mixed data which can be serialized by <b>json_encode</b>,
         * which is a value of any type other than a resource.
         * @since 5.4.0
         */
        public function jsonSerialize()
        {
            return $this->data;
        }
    }


    if (!function_exists('objectify')) {
        function objectify($array)
        {
            return new DomainObject($array);
        }
    }

    if (!function_exists('create_sample_series')){

        function create_sample_series()
        {
            $serie1 = Serie::create([
                'title' => 'TDD (Test Driven Development)',
                'description' => 'Bla bla bla',
                'image' => 'tdd.png',
                'teacher_name' => 'David Pont Lopez',
                'teacher_photo_url' => 'https://www.gravatar.com/avatar/' . md5('dpont@iesebre.com'),
                //'created_at' => Carbon::now()->addSeconds(1)
            ]);

            sleep(1);
            $serie2 = Serie::create([
                'title' => 'Crud amb Vue Laravel',
                'description' => 'Bla bla bla',
                'image' => 'crud.jpg',
                'teacher_name' => 'David Pont Lopez',
                'teacher_photo_url' => 'https://www.gravatar.com/avatar/' . md5('dpont@iesebre.com'),
                //'created_at' => Carbon::now()->addSeconds(1)
            ]);

            sleep(1);
            $serie3 = Serie::create([
                'title' => 'Ionic Real World',
                'description' => 'Bla bla bla',
                'image' => 'ionic_real_world.png',
                'teacher_name' => 'David Pont Lopez',
                'teacher_photo_url' => 'https://www.gravatar.com/avatar/' . md5('dpont@iesebre.com'),
                //'created_at' => Carbon::now()->addSeconds(1)
            ]);

            return [$serie1,$serie2,$serie3];
        }
    }
}

