<?php

namespace Tests\Feature\Serie;

use App\Models\Serie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\SerieApiController
 */

class SerieApiTest extends TestCase
{
    use RefreshDatabase;


    /** @test */

    public function guest_users_can_index_published_videos()
    {
        $serie=create_sample_series();

        $response = $this->getJson('/api/series/');

        $response->assertStatus(200);
        $response->assertJsonCount(count($serie));

    }

    /** @test*/
    public function guest_users_can_show_published_series()
    {
        $serie = Serie::create([
            'title' => 'TDD (Test Driven Development)',
            'description' => 'Bla bla bla',
            'image' => 'tdd.png',
            'teacher_name' => 'David Pont Lopez',
            'teacher_photo_url' => 'https://www.gravatar.com/avatar/' . md5('dpont@iesebre.com'),
        ]);

        $response = $this->getJson('/api/series/'.$serie->id);

        $response->assertStatus(200);

        $response->assertSee($serie->id);
        $response->assertSee($serie->title);
        $response->assertSee($serie->description);

        $response->assertJsonPath('title',$serie->title);

        $response->assertJson(fn (AssertableJson $json)=>
        $json->where('id',$serie->id)
            ->where('title',$serie->title)
            ->where('description',$serie->description)
            ->where('image',$serie->image)
            ->where('teacher_name',$serie->teacher_name)
            ->where('teacher_photo_url',$serie->teacher_photo_url)
            ->missing('password')
            ->etc()

        );
    }

    /** @test*/
    public function guest_users_cannot_show_unexisting_series()
    {
        $response = $this->get('/api/Series/999');

        $response->assertStatus(404);
    }

}
