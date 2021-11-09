<?php

namespace Tests\Feature\Video;

use App\Models\Video;
use Carbon\Carbon;
use Carbon\Exceptions\Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VideoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function users_can_view_videos()
    {

        $video = Video::create([
           'title' => 'Ubuntu 101',
           'description' => '# Here description',
           'url' => 'https://youtube/w8j07_DBL_I',
           'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
           'previous' => null,
           'next' => null,
           'series_id' => 1
        ]);

        // FASE 2 -> Execució -> Executa el codi a provar

        $response = $this->get('/videos/' . $video->id);

//dd('/videos/' .$video->id);

        // FASE 3 -> Assertions -> comprovacions
        $response->assertStatus(200);
        $response->assertSee('Ubuntu 101');
        $response->assertSee('# Here description');
        $response->assertSee('December 13');


    }
}
