<?php

namespace Tests\Feature;

use App\Models\Serie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

/**
 * @covers CasteachingSeries
 */
//https://i.imgur.com/c6Qdxz1.jpg
class CasteachingSeriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function guest_users_can_see_published_series()
    {
        $serie1 = Serie::create([
            'title' => 'TDD (Test Driven Development)',
            'description' => 'Bla bla bla',
            'image' => 'tdd.png',
            'teacher_name' => 'David Pont Lopez',
            'teacher_photo_url' => 'https://www.gravatar.com/avatar/' . md5('dpont@iesebre.com'),
            'created_at' => Carbon::now()->addSeconds(1)
        ]);

        $serie2 = Serie::create([
            'title' => 'Crud amb Vue Laravel',
            'description' => 'Bla bla bla',
            'image' => 'crud.jpg',
            'teacher_name' => 'David Pont Lopez',
            'teacher_photo_url' => 'https://www.gravatar.com/avatar/' . md5('dpont@iesebre.com'),
            'created_at' => Carbon::now()->addSeconds(2)
        ]);

        $serie3 = Serie::create([
            'title' => 'Ionic Real World',
            'description' => 'Bla bla bla',
            'image' => 'ionic_real_world.png',
            'teacher_name' => 'David Pont Lopez',
            'teacher_photo_url' => 'https://www.gravatar.com/avatar/' . md5('dpont@iesebre.com'),
            'created_at' => Carbon::now()->addSeconds(3)
        ]);

        $view = $this->blade('<x-casteaching-series/>');

        $view->assertSeeInOrder([$serie3->title,$serie2->title,$serie1->title]);
        $view->assertSeeInOrder([$serie3->description,$serie2->description,$serie1->description]);
        $view->assertSeeInOrder([$serie3->image,$serie2->image,$serie1->image]);
        $view->assertSeeInOrder([$serie3->teacher_name,$serie2->teacher_name,$serie1->teacher_name]);
        $view->assertSeeInOrder([$serie3->teacher_photo_url,$serie2->teacher_photo_url,$serie1->teacher_photo_url]);
    }
}
