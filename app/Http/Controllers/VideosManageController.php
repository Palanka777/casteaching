<?php

namespace App\Http\Controllers;

use App\Events\VideoCreated;
use App\Models\Video;
use Illuminate\Http\Request;
use PHPUnit\Util\Test;
use Tests\Feature\Video\VideosManageControllerTest;
use Tests\TestCase;
use RedisFacade;

class VideosManageController extends Controller
{
    public static function testedBy(){
        return VideosManageControllerTest::class;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('videos.manage.index',[
            'videos'=>Video::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $video=Video::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'url'=>$request->url,
        ]);
        session()->flash('status','Successfully created');

        VideoCreated::dispatch($video);

        return redirect(route('manage.videos'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('videos.manage.edit',[
            'video'=>Video::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $video=Video::findOrFail($id);

        $video->title = $request->title;
        $video->description = $request->description;
        $video->url = $request->url;

        $video->save();
        session()->flash('status','Successfully updated');
        return redirect(route('manage.videos'));

    }


    public function destroy($id)
    {
        Video::find($id)->delete();
        session()->flash('status','Successfully removed');
        return redirect(route('manage.videos'));
    }
}
