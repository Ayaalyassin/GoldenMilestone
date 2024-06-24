<?php

namespace App\Http\Controllers;

use App\Models\level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $levels=level::all();
        return response()->json($levels);
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
        $request->validate([
            'text'=>['required','string'],
        ]);

        $level=level::create([
            'text'=>$request->text,
        ]);

        return response()->json($level);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\level  $level
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $level=level::find($id);

        if(is_null($level))
        {
            return "level not found";
        }

        return response()->json($level);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\level  $level
     * @return \Illuminate\Http\Response
     */
    public function edit(level $level)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\level  $level
     * @return \Illuminate\Http\Response
     */
    public function updat(Request $request,$id)
    {
        $validator=Validator::make($request->all(),[
            'text'=>['required','string'],
        ]);


        if($validator->fails())
        {
            return response()->json($validator->errors()->all());
        }


        $level=level::find($id);

        if(is_null($level))
        {
            return response()->json("not found");
        }


        $level->update([
            'text'=>$request->text,

        ]);
        return response()->json($level);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\level  $level
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $level=level::find($id);
        if(is_null($level))
        {
            return "not found";
        }
        $level->delete();

        return response()->json("deleted");
    }
}
