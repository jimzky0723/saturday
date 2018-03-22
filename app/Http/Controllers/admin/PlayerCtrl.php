<?php

namespace App\Http\Controllers\admin;

use App\Players;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlayerCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $data = Players::orderBy('lname','asc')
                ->paginate(20);
        return view('admin.players',[
            'title' => 'List of Players',
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('admin.addPlayer',[
            'title' => 'Add Player'
        ]);
    }

    public function store(Request $req)
    {
        $tmp = array(
            $req->fname,
            $req->mname,
            $req->lname,
            date('Ymd',strtotime($req->dob))
        );
        $unique = implode("",$tmp);

        $prof_pic = self::uploadPicture($_FILES['prof_pic'],$unique,'profile');
        $portrait_pic = self::uploadPicture($_FILES['portrait_pic'],$unique,'portrait');

        $match = array('unique_id' => $unique);
        Players::updateOrCreate($match,
            [
                'fname'=>$req->fname,
                'mname'=>$req->mname,
                'lname'=>$req->lname,
                'dob'=>$req->dob,
                'position'=>$req->position,
                'jersey'=>$req->jersey,
                'height'=>$req->height,
                'weight'=>$req->weight,
                'section'=>$req->section,
                'prof_pic' => $prof_pic,
                'portrait_pic' => $portrait_pic,
                'status' => $req->status
            ]);

        return redirect()->back()->with('status','saved');
    }

    function uploadPicture($file,$name,$type)
    {
        $path = public_path('upload/'.$type);
        $size = getimagesize($file['tmp_name']);
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_name = $name.'.'.$ext;
        if($size==FALSE){
            $name = 'default.png';
        }else{
            //move uploaded file to a directory
            move_uploaded_file($file['tmp_name'],$path.'/'.$new_name);

            $name = $name.'.'.$ext;
        }
        return $name;
    }

    function edit($id)
    {
        $data = Players::find($id);
        return view('admin.addPlayer',[
            'title' => 'Update Player',
            'data' => $data
        ]);
    }

    function update(Request $req)
    {
        $unique = $req->unique_id;
        $match = array('unique_id' => $unique);
        if($_FILES['prof_pic']['name'])
        {
            $prof_pic = self::uploadPicture($_FILES['prof_pic'],$unique,'profile');
            Players::updateOrCreate($match,['prof_pic'=>$prof_pic]);
        }
        if($_FILES['portrait_pic']['name'])
        {
            $portrait_pic = self::uploadPicture($_FILES['portrait_pic'],$unique,'portrait');
            Players::updateOrCreate($match,['portrait_pic'=>$portrait_pic]);
        }


        Players::updateOrCreate($match,
            [
                'fname'=>$req->fname,
                'mname'=>$req->mname,
                'lname'=>$req->lname,
                'dob'=>$req->dob,
                'position'=>$req->position,
                'jersey'=>$req->jersey,
                'height'=>$req->height,
                'weight'=>$req->weight,
                'section'=>$req->section,
                'status'=>$req->status
            ]);

        return redirect()->back()->with('status','updated');

    }
}
