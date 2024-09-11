<?php


namespace App\Repositories;


use App\Models\Grammer;
use App\Models\level;
use Illuminate\Support\Facades\DB;

class GrammerRepository
{
    public function getById($level_id)
    {
        return level::find($level_id);
    }

    public function answers($level_id)
    {
        return DB::table('grammers')->where('level_id','=',$level_id)->get();
    }

    public function getLevel($request)
    {
        return level::where('text',$request->level)->first();
    }

    public function createGrammar($level,$request)
    {
        return $level->grammers()->create([
            'text'=>$request->text,
        ]);
    }

    public function grammarById($id)
    {
        return Grammer::find($id);
    }

    public function update($level,$request)
    {
        $level->grammers()->update([
            'text'=>$request->text,
        ]);
    }

}
