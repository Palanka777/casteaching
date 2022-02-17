<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use App\Models\Video;
use Illuminate\Http\Request;
use Tests\Feature\Serie\SerieApiTest;

class SerieApiController extends Controller
{
    public function testedBy()
    {
        return SerieApiTest::class;
    }

    public function index()
    {
        return Serie::all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        return Serie::findOrFail($id);
    }

}
