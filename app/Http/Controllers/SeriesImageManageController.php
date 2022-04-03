<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use Tests\Feature\Series\SeriesImageManageControllerTest;

class SeriesImageManageController extends Controller
{
    public static function testedBy(){
        return SeriesImageManageControllerTest::class;
    }

    public function update(Request $request)
    {
        $serie= Serie::findOrFail($request->id);
        $serie->image = $request->file('image')->store('series');
        $serie->save();
        session()->flash('status', __('Successfully updated'));

        return back()->withInput();
    }
    //
}
