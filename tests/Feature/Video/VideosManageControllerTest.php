<?php

namespace Tests\Feature\Video;

use App\Events\VideoCreated;
use App\Models\Serie;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;
use function PHPUnit\Framework\assertNull;

/** @covers VideosManageController */

// this->withoutExceptionDandling() es per veure els errors http mes descriptius

class VideosManageControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;
    /** @test */
    public function user_with_permissions_can_update_videos(){
        $this->loginAsVideoManager();

        $video=create_default_video();

        $response = $this->put('/manage/videos/'.$video->id,[
            'title' => 'Ubuntu 102',
            'description' => '# Here description 2',
            'url' => 'https://youtube/w8j07_DBL_I2',

        ]);
        $response->assertRedirect(route('manage.videos'));
        $response->assertSessionHas('status','Successfully updated');

        $newVideo=Video::find($video->id);

        $this->assertEquals('Ubuntu 102',$newVideo->title);
        $this->assertEquals('# Here description 2',$newVideo->description);
        $this->assertEquals('https://youtube/w8j07_DBL_I2',$newVideo->url);
        $this->assertEquals($video->id,$newVideo->id);



    }

    /** @test */

    public function user_with_permissions_can_see_edit_videos(){

        $this->loginAsVideoManager();

        $video=create_default_video();

        $response = $this->get('/manage/videos/'.$video->id);

        $response->assertStatus(200);
        $response->assertViewIs('videos.manage.edit');
        $response->assertViewHas('video', function ($v) use ($video){
            return $video->is($v);
        });
        $response->assertSee('form_video_edit',false);
        $response->assertSeeText($video->title);
        $response->assertSeeText($video->description);
        $response->assertSee($video->url);


    }

    /** @test */

    public function user_without_permissions_cannot_store_videos()
    {
        $this->loginAsRegularUser();

        $response = $this->post('/manage/videos',[
            'title'=>'HTTP for noobs',
            'description'=>'HTTP per petardos',
            'url'=>'https://www.aranolase.com',
        ]);

        $response->assertStatus(403);
        $response->assertSessionHas(null);

        $videoDB = Video::first();
        $this->assertNull($videoDB);


    }

    /** @test */

    public function user_with_permissions_can_destroy_videos(){
        $this->loginAsVideoManager();

        $video=create_default_video();

        $response = $this->delete('/manage/videos/'.$video->id);
        $response->assertRedirect(route('manage.videos'));

        $response->assertSessionHas('status','Successfully removed');
        $this->assertNull(Video::find($video->id));


    }

    /** @test */

    public function user_with_permissions_can_store_videos()
    {
        $this->loginAsVideoManager();

        $video=objectify([
            'title'=>'HTTP for noobs',
            'description'=>'HTTP per petardos',
            'url'=>'https://www.aranolase.com',
        ]);

        Event::fake();

        $response = $this->post('/manage/videos',[
            'title'=>'HTTP for noobs',
            'description'=>'HTTP per petardos',
            'url'=>'https://www.aranolase.com',
        ]);

        Event::assertDispatched(VideoCreated::class);

        $response->assertRedirect(route('manage.videos'));
        $response->assertSessionHas('status','Successfully created');

        //$response->assertStatus(201);
        $videoDB = Video::first();
        $this->assertNotNull($videoDB);
        $this->assertEquals($videoDB->title, $video->title);
        $this->assertEquals($videoDB->description, $video->description);
        $this->assertEquals($videoDB->url, $video->url);
        $this->assertNull($video->published_at);


    }

    /** @test */

    public function user_with_permissions_can_see_add_videos()
    {
        $this->loginAsVideoManager();

        $response = $this->get('/manage/videos');
        $response->assertStatus(200);
        $response->assertViewIs('videos.manage.index');
        $response->assertSee('<form data-qa="form_video_create"',false);

    }

    /** @test */

    public function regular_user_cannot_see_add_videos()
    {
        Permission::firstOrCreate(['name' => 'videos_manage_index']);

        $user= User::create([
            'name'=>'Pepito',
            'email'=>'info@pepito',
            'password'=>'12345678'
        ]);
        $user->givePermissionTo('videos_manage_index');
        Auth::login($user);

        add_personal_team($user);

        $response = $this->get('/manage/videos');
        $response->assertStatus(200);
        $response->assertViewIs('videos.manage.index');
        $response->assertDontSee('<form data-qa="form_video_create"',false);

    }


    /** @test */
   public function user_with_permissions_can_manage_videos()
    {
        $this->loginAsVideoManager();

        $videos=createSampleVideos();

        $response = $this->get('/manage/videos');

        $response->assertStatus(200);
        $response->assertViewIs('videos.manage.index');
        $response->assertViewHas('videos',function ($v) use ($videos){
            return $v->count() === count($videos) && get_class($v) === Collection::class && get_class($videos[0]) === Video::class;
        });

        foreach ($videos as $video) {
            $response->assertSee($video->id);
            $response->assertSee($video->title);
        }
    }

    /** @test */
    public function user_with_permissions_can_manage_videos_and_see_serie()
    {
        $this->loginAsVideoManager();

        $videos=createSampleVideos();

        $serie = Serie::create([
            'title' => 'TDD (Test Driven Development)',
            'description' => 'Bla bla bla',
            'image' => 'tdd.png',
            'teacher_name' => 'David Pont Lopez',
            'teacher_photo_url' => 'https://www.gravatar.com/avatar/' . md5('dpont@iesebre.com'),

        ]);


        $videos[0]->setSerie($serie);

        $response = $this->get('/manage/videos');

        $response->assertStatus(200);
        $response->assertViewIs('videos.manage.index');
        $response->assertViewHas('videos',function ($v) use ($videos){
            return $v->count() === count($videos) && get_class($v) === Collection::class && get_class($videos[0]) === Video::class;
        });

        foreach ($videos as $video) {
            $response->assertSee($video->id);
            $response->assertSee($video->title);
            $response->assertSee($video->serie_id);
        }
    }


    /** @test */
    public function title_is_required()
    {

        $this->loginAsVideoManager();

     $response = $this->postJson('/manage/videos/',[

         //'title'=> '123445678',
         'description' =>"Pepe's device",
         'url' =>"https://youtube/w8j07_DBL_I2"
     ]);

        $json_response = json_decode($response->getContent());
        $this->assertEquals("The title field is required.",$json_response->message);
        $this->assertEquals("The title field is required.",$json_response->errors->title[0]);

    }

    /** @test */
    public function description_is_required()
    {
        $this->loginAsVideoManager();

        $response = $this->postJson('/manage/videos/',[

            'title'=> 'Video 1',
            //'description' =>"Pepe's device",
            'url' =>"https://youtube/w8j07_DBL_I2"
        ]);

        $json_response = json_decode($response->getContent());
        $this->assertEquals("The description field is required.",$json_response->message);
        $this->assertEquals("The description field is required.",$json_response->errors->description[0]);
    }

    /** @test */
    public function url_is_required()
    {
        $this->loginAsVideoManager();

        $response = $this->postJson('/manage/videos/',[

            'title'=> '123445678',
            'description' =>"Pepe's device",
            //'url' =>"https://youtube/w8j07_DBL_I2"
        ]);

        $json_response = json_decode($response->getContent());
        $this->assertEquals("The url field is required.",$json_response->message);
        $this->assertEquals("The url field is required.",$json_response->errors->url[0]);

    }


    /** @test */
    public function regular_users_cannot_manage_videos()
    {
        $this->loginAsRegularUser();
        $response = $this->get('/manage/videos');

        $response->assertstatus(403);
    }

    /**
    @test
     */
    public function guest_users_cannot_manage_videos()
    {

        $response = $this->get('/manage/videos');

        $response->assertRedirect(route('login'));
    }

    /** @test */

    public function user_with_permissions_can_store_videos_with_series()
    {
        $this->loginAsVideoManager();

        $serie = Serie::create([
            'title' => 'TDD (Test Driven Development)',
            'description' => 'Bla bla bla',
            'image' => 'tdd.png',
            'teacher_name' => 'David Pont Lopez',
            'teacher_photo_url' => 'https://www.gravatar.com/avatar/' . md5('dpont@iesebre.com'),
        ]);

        $video=objectify([
            'title'=>'HTTP for noobs',
            'description'=>'HTTP per petardos',
            'url'=>'https://www.aranolase.com',
            'serie_id'=>$serie->id
        ]);

        Event::fake();

        $response = $this->post('/manage/videos',[
            'title'=>'HTTP for noobs',
            'description'=>'HTTP per petardos',
            'url'=>'https://www.aranolase.com',
            'serie_id'=>$serie->id
        ]);

        Event::assertDispatched(VideoCreated::class);

        $response->assertRedirect(route('manage.videos'));
        $response->assertSessionHas('status','Successfully created');

        //$response->assertStatus(201);
        $videoDB = Video::first();
        $this->assertNotNull($videoDB);
        $this->assertEquals($videoDB->title, $video->title);
        $this->assertEquals($videoDB->description, $video->description);
        $this->assertEquals($videoDB->url, $video->url);
        $this->assertEquals($videoDB->serie_id, $video->serie_id);
        $this->assertNull($video->published_at);


    }

    /** @test */

    public function user_with_permissions_can_store_videos_with_user_id()
    {
        $this->loginAsVideoManager();

        $user = User::create([
            'name' => 'Pepe Pardo Jeans',
            'email' => 'pepepardo@casteaching.com',
            'password' => Hash::make('12345678')
        ]);

        $video = objectify($videoArray = [
            'title' => 'HTTP for noobs',
            'description' => 'Te ensenyo tot el que se sobre HTTP',
            'url' => 'https://tubeme.acacha.org/http',
            'user_id' => $user->id
        ]);

        Event::fake();
        $response = $this->post('/manage/videos',$videoArray);

        Event::assertDispatched(VideoCreated::class);

        $response->assertRedirect(route('manage.videos'));
        $response->assertSessionHas('status', 'Successfully created');

        $videoDB = Video::first();

        $this->assertNotNull($videoDB);
        $this->assertEquals($videoDB->title,$video->title);
        $this->assertEquals($videoDB->description,$video->description);
        $this->assertEquals($videoDB->url,$video->url);
        $this->assertEquals($videoDB->user_id,$user->id);
        $this->assertNull($video->published_at);

    }


}
