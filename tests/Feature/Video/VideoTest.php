<?php

namespace Tests\Feature\Video;

use App\Models\Serie;
use App\Models\Video;
use Carbon\Carbon;
use Carbon\Exceptions\Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\VideosController
 */

class VideoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function users_can_view_video_series_navigation()
    {
        $serie = Serie::create([
            'title' => 'Introducció a Ubuntu',
            'description' => 'Bla bla bla',
            'teacher_name' => 'Sergi Tur Badenas',
            'teacher_photo_url' => $gravatar = 'https://www.gravatar.com/avatar/' . md5('sergiturbadenas@gmail.com')
        ]);

        $video = Video::create([
            'title' => 'Ubuntu 101',
            'description' => '# Here description',
            'url' => 'https://youtu.be/w8j07_DBl_I',
            'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
            'previous' => null,
            'next' => null,
            'serie_id' => $serie->id
        ]);

        $response = $this->get('/videos/' . $video->id); // SLUGS -> SEO -> TODO

        $response->assertStatus(200);
        $response->assertSee('Ubuntu 101');
        $response->assertSee('Here description');
        $response->assertSee('13 de desembre de 2020');
        $response->assertSee('https://youtu.be/w8j07_DBl_I');

        // NO ES MOSTRA LA NAVEGACIÓ DE SERIES
        $response->assertSee('<div id="layout_series_navigation"',false);
        $response->assertSee($serie->title);
        $response->assertSee($serie->teacher_name);
        $response->assertSee($gravatar);
    }

    /**
     * @test
     */
    public function users_can_view_videos_without_serie()
    {
        $video = Video::create([
            'title' => 'Ubuntu 101',
            'description' => '# Here description',
            'url' => 'https://youtu.be/w8j07_DBl_I',
            'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
            'previous' => null,
            'next' => null,
            'serie_id' => null
        ]);

        $response = $this->get('/videos/' . $video->id); // SLUGS -> SEO -> TODO

        $response->assertStatus(200);
        $response->assertSee('Ubuntu 101');
        $response->assertSee('Here description');
        $response->assertSee('13 de desembre de 2020');
        $response->assertSee('https://youtu.be/w8j07_DBl_I');

        // NO ES MOSTRA LA NAVEGACIÓ DE SERIES
        $response->assertDontSee('<div id="layout_series_navigation"',false);
    }

    /**
     * @test
     */
    public function users_can_view_videos()
    {

        //create_default_user();
        //create_default_video();
        $serie = Serie::create([
            'title' => 'TDD (Test Driven Development)',
            'description' => 'Bla bla bla'
        ]);

        $video = Video::create([
           'title' => 'Ubuntu 101',
           'description' => '# Here description',
           'url' => 'https://youtube/w8j07_DBL_I',
           'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
           'previous' => null,
           'next' => null,
           'serie_id' => $serie->id
        ]);

        // FASE 2 -> Execució -> Executa el codi a provar

        $response = $this->get('/videos/' . $video->id);

//dd('/videos/' .$video->id);

        // FASE 3 -> Assertions -> comprovacions
        $response->assertStatus(200);
        $response->assertSee('Ubuntu 101');
        $response->assertSee('Here description');
        $response->assertSee('13 de desembre de 2020');


    }

    /**
     * @test
     */
    public function users_cannot_view_not_existing_videos()
    {
        $response = $this->get('/videos/999');
        $response->assertStatus(404);

    }

}
