<?php

namespace App\Http\Controllers;

use App\Players;
use Illuminate\Http\Request;
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
        $data = Players::find($player_id);
        return view('guest.profile',[
            'title' => 'Players',
            'data' => $data
        ]);
    }
}
