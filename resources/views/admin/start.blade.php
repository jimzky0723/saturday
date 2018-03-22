<!DOCTYPE html>
<html lang="en" >

<head>
    <meta charset="UTF-8">
    <title>{{ $data->home_team }} vs. {{ $data->away_team }}</title>
    <link href="{{ asset('resources/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/assets/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/assets/css/game.css') }}" rel="stylesheet">
    <style>
        .team {
            color: #2786bf !important;
        }
        .title-info {
            color: #00ca6d;
            font-weight: bold;
            font-size: 1.4em;
        }
        .columns {
            padding:0px !important;
        }
    </style>
</head>
<body>
<?php
$players = \App\Boxscore::where('game_id',$data->id)
    ->where('team',$team)
    ->get();
?>
<div id="social-platforms">
    <h1 class="team">{{ $team }} | <font class="title-info score">0</font> </h1>
    @foreach($players as $row)
    <?php
        $player = \App\Players::find($row->player_id);
    ?>
    <a class="btn btn-icon btn-twitter" href="#basketModal" data-toggle="modal">
        <i>
            {{ $player->fname[0] }}. {{ $player->lname }}<br /><small>{{ $player->position }} | {{ $player->jersey}}</small>
        </i>
        <span><img src="{{ url('public/upload/profile/'.$player->prof_pic.'?img='.date('YmdHis')) }}" width="80px" class="img-responsive" /></span>
    </a>
    @endforeach
</div>
</body>

<div class="modal fade" role="dialog" id="basketModal">
    <div class="modal-dialog modal-sm" role="document">
        {{ csrf_field() }}
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-sm-4 columns">
                    <button type="button" data-dismiss="modal" class="btn btn-default">
                        <img src="{{ url('public/upload/icons/2pt.png') }}" class="img-responsive" />
                    </button>
                </div>
                <div class="col-sm-4 columns">
                    <button type="button" data-dismiss="modal" class="btn btn-default">
                        <img src="{{ url('public/upload/icons/3pt.png') }}" class="img-responsive" />
                    </button>
                </div>
                <div class="col-sm-4 columns">
                    <button type="button" data-dismiss="modal" class="btn btn-default">
                        <img src="{{ url('public/upload/icons/ft.png') }}" class="img-responsive" />
                    </button>
                </div>
                <div class="clearfix"></div>
            </div>
        </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="{{ asset('resources/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('resources/assets/js/bootstrap.min.js') }}"></script>
</html>
