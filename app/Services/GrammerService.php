<?php


namespace App\Services;

use App\Http\Requests\GrammerRequest;
use App\Models\Grammer;
use App\Models\level;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class GrammerService
{
    public function index($level_id)
    {
        $true=level::find($level_id);
        if(!$true)
        {
            throw new HttpResponseException(response()->json("error"));
        }

        $grammers=DB::table('grammers')->where('level_id','=',$level_id)->get();
        if(count($grammers)<0)
        {
            throw new HttpResponseException(response()->json("grammers not found"));
        }
        return $grammers;
    }


    public function store(GrammerRequest $request)
    {
        $level=level::where('text',$request->level)->first();

        if(is_null($level))
        {
            throw new HttpResponseException(response()->json("level not found"));
        }

        $grammer=$level->grammers()->create([
            'text'=>$request->text,
        ]);

        return $grammer;
    }


    public function show($id)
    {
        $grammer=Grammer::find($id);

        if(is_null($grammer))
        {
            throw new HttpResponseException(response()->json("grammer not found"));
        }

        return $grammer;
    }


    public function update(GrammerRequest $request,$id)
    {
        $level=level::where('text','=',$request->level)->first();

        if(is_null($level))
        {
            throw new HttpResponseException(response()->json("the level not found"));
        }

        $grammer=Grammer::find($id);

        if(is_null($grammer))
        {
            throw new HttpResponseException(response()->json("grammer not found"));
        }
        $level->grammers()->update([
            'text'=>$request->text,
        ]);

    }

    public function destroy($id)
    {
        $grammer=Grammer::find($id);
        if(is_null($grammer))
        {
            throw new HttpResponseException(response()->json("not found"));
        }
        $grammer->delete();
    }

}
