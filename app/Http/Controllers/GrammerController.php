<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grammer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\level;
use App\Models\Course;

class GrammerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($level_id)
    {
        $true=level::find($level_id);
        if(!$true)
        {
            return response()->json("error");
        }

        $grammers=DB::table('grammers')->where('level_id','=',$level_id)->get();
        if(count($grammers)<0)
        {
            return response()->json("grammers not found");
        }
        return response()->json($grammers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'level'=>['required','string'],
            'text'=>['required','string'],
        ]);


        $level=level::where('text',$request->level)->first();


        if(is_null($level))
        {
             return response()->json("level not found");
        }

        $grammer=$level->grammers()->create([
            'text'=>$request->text,
        ]);

        return response()->json($grammer);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grammer  $grammer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $grammer=Grammer::find($id);

        if(is_null($grammer))
        {
            return "grammer not found";
        }

        return response()->json($grammer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grammer  $grammer
     * @return \Illuminate\Http\Response
     */
    public function edit(Grammer $grammer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grammer  $grammer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validator=Validator::make($request->all(),[
            'text'=>['required','string'],
            'level'=>['required','string'],
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors()->all());
        }

        $level=level::where('text','=',$request->level)->first();

        if(is_null($level))
        {
            return response()->json("the level not found");
        }

        $grammer=Grammer::find($id);

        if(is_null($grammer))
        {
            return response()->json("grammer not found");
        }
        $level->grammers()->update([
            'text'=>$request->text,
        ]);

        return response()->json("updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\level  $level
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grammer=Grammer::find($id);
        if(is_null($grammer))
        {
            return "not found";
        }
        $grammer->delete();
        return response()->json("deleted");
    }
}
