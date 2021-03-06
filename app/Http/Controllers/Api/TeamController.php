<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Team;
use Carbon\Carbon;
class TeamController extends Controller
{

    public function create(Request $request){
        $user = $request->user();
        $task = $user->todaytask();       
        if($task->team_id) return response()->json(['message'=>'已经完成组队']);
        $todayteam = $user->joinTeams()->where('teams.did','=',date('Ymd'))->first();
        if($todayteam) return response()->json(['message'=>'已经加入队伍，请先退出队伍！']); 
        $team_name = ($user->name ? $user->name : $user->id).'_'.date('Ymd'); 
        
        $team = Team::Create(['user_id' => $user->id,'appid' => $user->appid, 'did' => date('Ymd'), 'name' => $team_name,'total'=>0]);
        $user->joinTeams()->attach($team->id);
        $team->users;
        $intro = '距离组队成功还差'.( 5-count($team->users)).'人。' ;
        $team->intro = $intro;
        $user->team = $team;
        return response()->json($user);
    }

    public function join(Request $request){
        $team_id = $request->get('team_id');
        $team = Team::findOrFail($team_id);
        $user = $request->user();
        $task = $user->todaytask();       
        if($task->full_at) return response()->json(['message'=>'该队伍已经满员']);
        if($task->team_id) return response()->json(['message'=>'已经完成组队']);
        if( date('Ymd') != $team->did )return response()->json(['message'=>'队伍已过期，请寻找新队伍']);
        $todayteam = $user->joinTeams()->where('teams.did','=',date('Ymd'))->first();
        if($todayteam && $todayteam->id != $team->id  ) 
        return response()->json(['message'=>'已经加入其它队伍！']); 
        if($todayteam && $todayteam->id == $team->id  ) 
        return response()->json(['message'=>'已经加入该队伍']); 
        $user->joinTeams()->attach($team->id);
        $team->users;
        $intro = '距离组队成功还差'.( 5-count($team->users)).'人。' ;
        if(count($team->users)==5){ //组队达5人时执行
            // 发放完成组队奖励
            $ids = collect($team->users)->pluck('id')->all();
            $tasks = Task::where('did', '=', date('Ymd'))->whereIn('user_id',$ids)->get();
            if($tasks){
                $team->full_at = Carbon::now();
                $team->user_ids = implode(',',$ids);
                $team->save();
                foreach($tasks as $t){
                    $t->team_id = $team->id;
                    $t->save();
                }
            }
            $intro = '组队成功。进行阅读、点赞可获得积分*2' ;
        }  
        $team->intro = $intro;
        $team->can_join = false; //标记不能再进队
        $team->user = $user;
        return response()->json($team);
    }
    
    public function show(Request $request){
        $team_id = $request->get('team_id');
        $team = Team::findOrFail($team_id);
        $team->users;
        $intro = '距离组队成功还差'.( 5-count($team->users)).'人。' ;
        if(count($team->users)>=5){
            $intro = '组队成功。进行阅读、点赞可获得积分*2' ;
        }

        if( date('Ymd') != $team->did ){
            $intro = "队伍已过期，请寻找新队伍" ;
        }

        $team->intro = $intro;
        $user = $request->user();
        $team->can_join = true;
        foreach( $team->users as $fan){
            if($fan->id == $user->id){
                $team->can_join = false;
                break;
            }
        }
        $team->user = $user;
        return response()->json($team);
    }
    
    public function search(Request $request){
        $id = intval($request->get('team_id'));
        if(!$id) return response()->json(['message'=>'输入不正确！']); 
        
        $team = Team::where('id','=',$id)->where('did','=',date('Ymd'))->first();
        if(!$team) return response()->json(['message'=>'队伍不存在！']); 
        
        return response()->json($team);
    }

    public function getme(Request $request){
        $user = $request->user();
        // $user->task = $user->todaytask();
        $user->team = $user->joinTeams()->where('teams.did','=',date('Ymd'))->first();
        if($user->team){
            $user->team->users;
            $intro = '距离组队成功还差'.( 5-count($user->team->users)).'人。' ;
            if(count($user->team->users)>=5){
                $intro = '组队成功。进行阅读、点赞可获得积分*2' ;
            }
            $user->team->intro = $intro;
        }
        return response()->json($user);
    }
}
