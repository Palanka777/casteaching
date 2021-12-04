<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use PHPUnit\Util\Test;
use Tests\Feature\Video\VideosManageControllerTest;
use Tests\TestCase;

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
        Video::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'url'=>$request->url,
        ]);
        session()->flash('status','Successfully created');
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
        //
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
        //
    }


    public function destroy($id)
    {
        Video::find($id)->delete();
        session()->flash('status','Successfully removed');
        return redirect(route('manage.videos'));
    }
}
