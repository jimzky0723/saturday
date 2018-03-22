<?php

namespace App\Http\Controllers\admin;

use App\Games;
use App\Boxscore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $data = Games::orderBy('date_match','desc')
                ->groupBy('date_match')
                ->paginate(5);
        return view('admin.games',[
            'title' => 'Game Schedule',
            'data' => $data
        ]);
    }

    public function store(Request $req)
    {
        $data = array(
            'home_team' => $req->home_team,
            'away_team' => $req->away_team,
            'date_match' => $req->date_match
        );
        Games::create($data);

        return redirect()->back()->with('status','saved');
    }

    public function assign($game_id)
    {
        $data = Games::find($game_id);
        return view('admin.assign',[
            'title' => 'Team Roster',
            'data' => $data
        ]);
    }

    public function assignPlayer(Request $req)
    {
        foreach($req->players as $row)
        {
            $data = array(
                'game_id' => $req->game_id,
                'team' => $req->team,
                'player_id' => $row
            );
            Boxscore::create($data);
        }
        return redirect()->back()->with('status',$req->side);

    }

    public function boxscore($game_id)
    {
        $data = Games::find($game_id);
        return view('admin.boxscore',[
            'title' => 'Box Score',
            'data' => $data
        ]);
    }

    public function calculate($game_id)
    {
        $game = Games::find($game_id);
        $home = $game->home_team;
        $away = $game->away_team;
        $game_id = $game->id;

        $home_score = Boxscore::where('team',$home)
                ->where('game_id',$game_id)
                ->sum('pts');
        $away_score = Boxscore::where('team',$away)
            ->where('game_id',$game_id)
            ->sum('pts');
        if($home_score==0 && $away_score==0){
            return redirect()->back();
        }

        if($home_score > $away_score)
        {
            $winner = Boxscore::where('team',$home)
                ->where('game_id',$game_id)
                ->orderBy('pts','desc')
                ->limit(1)
                ->first();
            $winner_id = $winner->player_id;
            $winner_score = $winner->pts;

            $losser = Boxscore::where('team',$away)
                ->where('game_id',$game_id)
                ->orderBy('pts','desc')
                ->limit(1)
                ->first();
            $losser_id = $losser->player_id;
            $losser_score = $losser->pts;
        }else{
            $winner = Boxscore::where('team',$away)
                ->where('game_id',$game_id)
                ->orderBy('pts','desc')
                ->limit(1)
                ->first();
            $winner_id = $winner->player_id;
            $winner_score = $winner->pts;

            $losser = Boxscore::where('team',$home)
                ->where('game_id',$game_id)
                ->orderBy('pts','desc')
                ->limit(1)
                ->first();
            $losser_id = $losser->player_id;
            $losser_score = $losser->pts;
        }

        $data = array(
            'home_score' => $home_score,
            'away_score' => $away_score,
            'winner_id' => $winner_id,
            'winner_score' => $winner_score,
            'losser_id' => $losser_id,
            'losser_score' => $losser_score
        );
        Games::where('id',$game_id)
            ->update($data);
        return redirect()->back();
    }

    public function removePlayer($game_id,$player_id)
    {
        Boxscore::where('game_id',$game_id)
            ->where('player_id',$player_id)
            ->delete();
        return redirect()->back()->with('status','deleted');
    }

    public function manualStats($game_id,$player_id)
    {
        $stats = Boxscore::where('game_id',$game_id)
            ->where('player_id',$player_id)
            ->first();
        return $stats;
    }

    public function saveManualStats(Request $req)
    {
        $match = array(
            'game_id' => $req->game_id,
            'player_id' => $req->player_id
        );
        $pt1 = $req->ftm * 1;
        $pt2 = $req->f2m * 2;
        $pt3 = $req->f3m * 3;
        $pts = $pt1+$pt2+$pt3;
        $data = array(
            'fg2m' => $req->f2m,
            'fg2a' => $req->f2a,
            'fg3m' => $req->f3m,
            'fg3a' => $req->f3a,
            'ftm' => $req->ftm,
            'fta' => $req->fta,
            'oreb' => $req->oreb,
            'dreb' => $req->oreb,
            'ast' => $req->ast,
            'stl' => $req->stl,
            'blk' => $req->blk,
            'turnover' => $req->turnover,
            'pts' => $pts
        );
        Boxscore::updateOrCreate($match,$data);
        return redirect()->back();
    }
}
