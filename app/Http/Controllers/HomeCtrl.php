<?php

namespace App\Http\Controllers;

use App\Boxscore;
use App\Games;
use App\Players;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeCtrl extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $user = Session::get('auth');
        if($user){
            if($user->level=='admin'){
                return redirect($user->level);
            }else if($user->level=='hospital'){
                return redirect($user->level);
            }
        }

        return view('guest.home',[
            'title' => 'DOH Basketball Club',
        ]);
    }

    public function players()
    {
        $data = Players::orderBy('lname','asc')
            ->paginate(20);
        return view('guest.players',[
            'title' => 'Players',
            'data' => $data
        ]);
    }

    public function profile($player_id)
    {
        $name = Players::find($player_id);
        $data = Players::find($player_id);
        $boxscore = Boxscore::where('player_id',$player_id);
        $total = $boxscore->leftJoin('games','games.id','=','boxscore.game_id')
            ->where('games.winner','!=','')
            ->count();
        $ppg = 0;
        $apg = 0;
        $orebpg = 0;
        $drebpg = 0;
        $fg2m = 0;
        $fg2a = 0;
        $fg3m = 0;
        $fg3a = 0;
        $ftm = 0;
        $fta = 0;
        $bpg = 0;
        $spg = 0;
        $pfpg = 0;
        $tpg = 0;

        if($total>0)
        {
            $ppg = number_format(($boxscore->sum('pts')) / $total,1);
            $apg = number_format(($boxscore->sum('ast')) / $total,1);
            $orebpg = number_format(($boxscore->sum('oreb')) / $total,1);
            $drebpg = number_format(($boxscore->sum('dreb')) / $total,1);
            $fg2m = number_format(($boxscore->sum('fg2m')) / $total,1);
            $fg2a = number_format(($boxscore->sum('fg2a')) / $total,1);
            $fg3m = number_format(($boxscore->sum('fg3m')) / $total,1);
            $fg3a = number_format(($boxscore->sum('fg3a')) / $total,1);
            $ftm = number_format(($boxscore->sum('ftm')) / $total,1);
            $fta = number_format(($boxscore->sum('fta')) / $total,1);
            $bpg = number_format(($boxscore->sum('blk')) / $total,1);
            $spg = number_format(($boxscore->sum('stl')) / $total,1);
            $pfpg = number_format(($boxscore->sum('pf')) / $total,1);
            $tpg = number_format(($boxscore->sum('turnover')) / $total,1);
        }


        $career = array(
            'gp' => $total,
            'ppg' => $ppg,
            'apg' => $apg,
            'orebpg' => $orebpg,
            'drebpg' => $drebpg,
            'rpg' => number_format($orebpg + $drebpg,1),
            'fg2m' => $fg2m,
            'fg2a' => $fg2a,
            'fg3m' => $fg3m,
            'fg3a' => $fg3a,
            'ftm' => $ftm,
            'fta' => $fta,
            'bpg' => $bpg,
            'spg' => $spg,
            'pfpg' => $pfpg,
            'tpg' => $tpg
        );

        $game_log = Games::select('games.*','boxscore.team as myteam')
                ->leftJoin('boxscore','boxscore.game_id','=','games.id')
                ->where('boxscore.player_id',$player_id)
                ->where('games.winner','!=','')
                ->orderBy('date_match','desc')
                ->limit(10)
                ->get();

        return view('guest.profile',[
            'title' => '#'.$name->jersey.' '.$name->fname.' '.$name->lname.', '.$name->position,
            'data' => $data,
            'career' => $career,
            'game_log' => $game_log,
            'player_id' => $player_id
        ]);
    }

    public function score()
    {
        $data = Games::orderBy('date_match','desc')
                ->groupBy('date_match')
                ->paginate(1);
        return view('guest.score',[
            'title' => 'Scoreboard',
            'data' => $data
        ]);
    }

    public function boxscore($game_id)
    {
        $data = Games::find($game_id);
        return view('guest.boxscore',[
            'title' => 'Box Score',
            'data' => $data
        ]);
    }

    public function ranking()
    {

        $stats = Boxscore::select(
            'player_id',
            DB::raw('count(team) as gp'),
            DB::raw('SUM(pts) as pts'),
            DB::raw('SUM(ast) as ast'),
            DB::raw('SUM(stl) as stl'),
            DB::raw('SUM(blk) as blk'),
            DB::raw('SUM(turnover) as turnover'),
            DB::raw('(SUM(oreb)+SUM(dreb)) as reb'),
            DB::raw('(SUM(pts) + (SUM(oreb)+SUM(dreb)) + SUM(ast) + SUM(stl) + SUM(blk))-(((SUM(fg2a)+SUM(fg3a)) - (SUM(fg3m)+SUM(fg2m))) + (SUM(fta) - SUM(ftm)) + (SUM(turnover))) as eff')
        )
            ->orderBy('eff','desc')
            ->groupBy('player_id')
            ->limit(30)
            ->get();
        return view('guest.ranking',[
            'title' => 'TOP 30 Players: Overall Stats',
            'data' => $stats
        ]);
    }

    public function stats(Request $req)
    {
        $sort = 'scoring';
        if($req->sort){
            $sort = $req->sort;
        }
        $data = Boxscore::select(
            'player_id',
            DB::raw('count(team) as gp'),
            DB::raw('SUM(pts)/count(team) as pts'),
            DB::raw('SUM(ast)/count(team) as ast'),
            DB::raw('SUM(stl)/count(team) as stl'),
            DB::raw('SUM(blk)/count(team) as blk'),
            DB::raw('SUM(fg2m)/count(team) as fg2m'),
            DB::raw('SUM(fg2a)/count(team) as fg2a'),
            DB::raw('SUM(fg3m)/count(team) as fg3m'),
            DB::raw('SUM(fg3a)/count(team) as fg3a'),
            DB::raw('(SUM(fg2m) + SUM(fg3m))/(SUM(fg2a) + SUM(fg3a)) as fg_per'),
            DB::raw('(SUM(fg3m))/(SUM(fg3a)) as fg3_per'),
            DB::raw('(SUM(ftm))/(SUM(fta)) as ft_per'),
            DB::raw('SUM(turnover)/count(team) as turnover'),
            DB::raw('((SUM(oreb)+SUM(dreb)))/count(team) as reb')
        );

        $title = 'Points Per Game Statistics';
        $col = 'pts';
        if($sort=='assist'){
            $title = 'Assist Per Game Statistics';
            $col = 'ast';
        }else if($sort=='rebound'){
            $title = 'Rebound Per Game Statistics';
            $col = 'reb';
        }else if($sort=='steal'){
            $title = 'Steal Per Game Statistics';
            $col = 'stl';
        }else if($sort=='turnover'){
            $title = 'Turnover Per Game Statistics';
            $col = 'turnover';
        }else if($sort=='fieldgoal'){
            $title = 'Field Goal %';
            $col = 'fg_per';
        }else if($sort=='block'){
            $title = 'Block Per Game Statistics';
            $col = 'blk';
        }else if($sort=='3-fieldgoal'){
            $title = '3-Point Field Goals';
            $col = 'fg3_per';
        }else if($sort=='freethrow'){
            $title = 'Free-Throw Shooting Statistics';
            $col = 'ft_per';
        }

        $data = $data->orderBy($col,'desc')
            ->groupBy('player_id')
            ->limit(30)
            ->get();

        return view('guest.stats',[
            'title' => $title,
            'data' => $data,
            'sort' => $col
        ]);
    }
}
