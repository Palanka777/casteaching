<?php

namespace Tests\Feature\Video;

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;
use function PHPUnit\Framework\assertNull;

/** @covers VideosManageController */

// this->withoutExceptionDandling() es per veure els errors http mes descriptius

class VideosManageControllerTest extends TestCase
{
    use RefreshDatabase;
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

        $response = $this->post('/manage/videos',[
            'title'=>'HTTP for noobs',
            'description'=>'HTTP per petardos',
            'url'=>'https://www.aranolase.com',
        ]);

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
    public function superadmins_can_manage_videos()
    {
        $this->loginAsSuperAdmin();

        $response = $this->get('/manage/videos');

        $response->assertStatus(200);
        $response->assertViewIs('videos.manage.index');
    }

    private function loginAsVideoManager()
    {
        Auth::login(create_videomanager_user());
    }

    private function loginAsSuperAdmin()
    {
        Auth::login(create_superadmin_user());
    }

    private function loginAsRegularUser()
    {
        Auth::login(create_regular_user());

    }
}
