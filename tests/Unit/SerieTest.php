<?php

namespace Tests\Unit;

use App\Models\Serie;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

/**
 * @covers \App\Models\Serie
 */

class SerieTest extends TestCase
{
    use RefreshDatabase;
    /** @test*/
    public function serie_have_videos()
    {
        $serie = Serie::create([
            'title' => 'TDD (Test Driven Development)',
            'description' => 'Bla bla bla',
            'image' => 'tdd.png',
            'teacher_name' => 'David Pont Lopez',
            'teacher_photo_url' => 'https://www.gravatar.com/avatar/' . md5('dpont@iesebre.com'),
            'created_at' => Carbon::now()->addSeconds(1)
        ]);

        $this->assertNotNull($serie->videos);
        $this->assertCount(0,$serie->videos);

        $video = Video::create([
            'title' => 'TDD (Test Driven Development)',
            'description' => 'Bla bla bla',
            'url' => 'https://www.youtube.com/watch?v=0F_jX4-T4C4&list=PLyasg1A0hpk18B-RSAR3wGrySpEDFhByb&index=2',
            'serie_id' => $serie->id
        ]);
        $serie->refresh();

        $this->assertNotNull($serie->videos);
        $this->assertCount(1,$serie->videos);
    }
}
