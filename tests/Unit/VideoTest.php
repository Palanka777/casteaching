<?php

namespace Tests\Unit;

use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VideoTest extends TestCase
{
    use RefreshDatabase;
    /**
    @test
     */
    public function can_get_formatted_pusblished_at_date()
    {

        // 1-Preparacio

        //TODO CODE SMELL
        $video = Video::create([
            'title' => 'Ubuntu 101',
            'description' => '# Here description',
            'url' => 'https://youtube/w8j07_DBL_I',
            'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
            'previous' => null,
            'next' => null,
            'series_id' => 1
        ]);

        // 2- Execucio WISHFUL PROGRAMMING
        $dateToTest = $video->formatted_published_at;

        // 3-Comprovacions
        $this->assertEquals($dateToTest, '13 de desembre de 2020');
    }

    public function can_get_formatted_pusblished_at_date_when_not_published()
    {

        // 1-Preparacio

        //TODO CODE SMELL
        $video = Video::create([
            'title' => 'Ubuntu 101',
            'description' => '# Here description',
            'url' => 'https://youtube/w8j07_DBL_I',
            'published_at' => null,
            'previous' => null,
            'next' => null,
            'series_id' => 1
        ]);

        // 2- Execucio WISHFUL PROGRAMMING
        $dateToTest = $video->formatted_published_at;

        // 3-Comprovacions
        $this->assertEquals($dateToTest, '');
    }
}
