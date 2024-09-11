<?php

namespace App\Http\Controllers;

use App\Models\level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LevelController extends Controller
{

    public function index()
    {
        $levels=level::all();
        return response()->json($levels);
    }


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


    public function show($id)
    {
        $level=level::find($id);

        if(is_null($level))
        {
            return "level not found";
        }

        return response()->json($level);
    }


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
