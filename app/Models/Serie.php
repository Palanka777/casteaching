<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\File;
use Tests\Unit\SerieTest;

class Serie extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public static function testedBy()
    {
        return SerieTest::class;
    }

    public function getFormattedCreatedAttribute(){

        if (!$this->created_at) return '';
        $locale_date = $this->created_at->locale(config('app.locale'));
        return $locale_date->day . ' de ' . $locale_date->monthName . ' de ' . $locale_date->year;

    }

    public function getFormattedHumansCreatedAttribute(){

        return optional($this->created_at)->diffForHumans(Carbon::now());

    }

    public function getCreatedTimestampAttribute(){

        return optional($this->created_at)->timestamp;

    }

    protected function imageUrl(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $this->image ?? 'series/placeholder.png',
        );
    }

    protected function url(): Attribute
    {
        return new Attribute(
            get: fn ($value) => count($this->videos) > 0 ? '/videos/' . $this->videos->first()->id : '#'
        );
    }

}
