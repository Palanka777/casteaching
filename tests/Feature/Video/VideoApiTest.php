<?php

namespace Tests\Feature\Video;

use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\VideosApiController::class
 */
class VideoApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function regular_users_cannot_update_videos()
    {
//        $this->withoutExceptionHandling();
        $this->loginregularUsers();
        $video= create_default_video();

        $response = $this->putJson('/api/videos/'. $video->id);
        $response
            ->assertStatus(403);

        $newVideo = Video::find($video['id']);
        $this->assertEquals($newVideo->id, $video->id);
        $this->assertEquals($newVideo->title, $video->title);
        $this->assertEquals($newVideo->descrption, $video->descrption);
        $this->assertEquals($newVideo->url, $video->url);
    }

    /** @test */

    public function guest_users_cannot_update_videos()
    {

        $video=create_default_video();

        $response = $this->putJson('/api/videos/'. $video->id);

        $response
            ->assertStatus(401);

        $newVideo = Video::find($video['id']);
        $this->assertEquals($newVideo->id, $video->id);
        $this->assertEquals($newVideo->title, $video->title);
        $this->assertEquals($newVideo->descrption, $video->descrption);
        $this->assertEquals($newVideo->url, $video->url);
    }

    /** @test */

    public function returns_404_when_updating_unexisting_video()
    {

        $this->loginAsVideoManager();

        $response = $this->putJson('/api/videos/999');

        $response
            ->assertStatus(404);
    }

    /** @test */

    public function users_with_permision_can_update_videos()
    {

        $this->loginAsVideoManager();
        $video=create_default_video();

        $response = $this->deleteJson('/api/videos/'. $video->id);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json)=>
            $json->has('id')
                ->where('title',$video['title'])
                ->where('url',$video['url'])
                ->etc()
            );


        $this->assertNull(Video::find($response['id']));

    }
    
    /** @test */

    public function regular_users_cannot_destroy_videos()
    {
//        $this->withoutExceptionHandling();
        $this->loginregularUsers();
        $video= create_default_video();

        $response = $this->deleteJson('/api/videos/'. $video->id);
        $response
            ->assertStatus(403);

        $this->assertNotNull(Video::find($video->id));
    }

    /** @test */

    public function guest_users_cannot_destroy_videos()
    {

        $video=create_default_video();

        $response = $this->deleteJson('/api/videos/'. $video->id);

        $response
            ->assertStatus(401);

        $this->assertNotNull(Video::find($video->id));
    }

    /** @test */

    public function returns_404_when_deleting_unexisting_video()
    {

        $this->loginAsVideoManager();

        $response = $this->deleteJson('/api/videos/999');

        $response
            ->assertStatus(404);
    }

    /** @test */

    public function users_with_permision_can_destroy_videos()
    {

        $this->loginAsVideoManager();
        $video=create_default_video();

        $response = $this->deleteJson('/api/videos/'. $video->id);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json)=>
            $json->has('id')
                ->where('title',$video['title'])
                ->where('url',$video['url'])
                ->etc()
            );


        $this->assertNull(Video::find($response['id']));

    }



    /** @test */

    public function regular_users_cannot_store_videos()
    {
        $this->loginregularUsers();
        $response = $this->postJson('/api/videos/', $video=[
            'title'=>'HTTP for noobs',
            'description'=>'HTTP per petardos',
            'url'=>'https://www.aranolase.com',
        ]);

        $response
            ->assertStatus(403);

            $this->assertCount(0,Video::all());
    }

    /** @test */

    public function guest_users_cannot_store_videos()
    {

        $response = $this->postJson('/api/videos/', $video=[
            'title'=>'HTTP for noobs',
            'description'=>'HTTP per petardos',
            'url'=>'https://www.aranolase.com',
        ]);

        $response
            ->assertStatus(401);

            $this->assertCount(0,Video::all());
    }


    /** @test */

    public function users_with_permision_can_store_videos()
    {

        $this->loginAsVideoManager();
        $response = $this->postJson('/api/videos/', $video=[
            'title'=>'HTTP for noobs',
            'description'=>'HTTP per petardos',
            'url'=>'https://www.aranolase.com',
        ]);

        $response
            ->assertStatus(201)
            ->assertJson(fn (AssertableJson $json)=>
                $json->has('id')
                    ->where('title',$video['title'])
                    ->where('url',$video['url'])
                    ->etc()
        );


        $newVideo=Video::find($response['id']);
        $this->assertEquals($response['id'],$newVideo->id);
        $this->assertEquals($response['title'],$newVideo->title);
        $this->assertEquals($response['description'],$newVideo->description);
        $this->assertEquals($response['url'],$newVideo->url);



    }

    /** @test */

    public function guest_users_can_index_published_videos()
    {
        $videos=createSampleVideos();
        $response = $this->get('/api/videos/');

        $response->assertStatus(200);
        $response->assertJsonCount(count($videos));

    }

    /** @test */

    public function guest_users_can_show_published_videos()
    {
        $video=create_default_video();

/*        $response = $this->get('/api/videos/' . $video->id);
        $response = $this->json('GET','/api/videos/' . $video->id);*/
        $response = $this->getJson('/api/videos/' . $video->id);

        $response->assertStatus(200);
        $response->assertSee($video->id);
        $response->assertSee($video->title);
        $response->assertSee($video->description);

        $response->assertJsonPath('title',$video->title);

        $response->assertJson(fn (AssertableJson $json)=>
        $json->where('id',$video->id)
            ->where('title',$video->title)
            ->where('url',$video->url)
            ->missing('password')
            ->etc()
        );
    }

    /** @test */

    public function guest_users_cannot_show_unexisting_videos()
    {
        $response = $this->get('/api/Videos/999');

        $response->assertStatus(404);
    }

    private function loginAsVideoManager()
    {
        Auth::login(create_videomanager_user());

    }

    private function loginregularUsers()
    {
        Auth::login(create_regular_user());
    }
}

