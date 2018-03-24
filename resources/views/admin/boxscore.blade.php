@extends('layouts.app')

@section('content')
    <?php
    $status = session('status');
    ?>
    <style>
        th {
            vertical-align: middle !important;
        }
        .score {
            font-weight: bold;
            font-size: 1.6em;
        }
    </style>
    <div class="col-md-12">
        <div class="jim-content">
            <div class="text-center">
                <h3 class="page-header">
                <?php
                    $home_score = \App\Boxscore::where('game_id',$data->id)
                        ->where('team',$data->home_team)
                        ->sum('pts');

                    $away_score = \App\Boxscore::where('game_id',$data->id)
                        ->where('team',$data->away_team)
                        ->sum('pts');
                ?>
                {{ $data->home_team }} <font class="text-primary score">{{ $home_score }}</font> <font class="score">|</font>  <font class="text-primary score">{{ $away_score }}</font> {{ $data->away_team }}
                </h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @if($status=='saved')
                        <div class="alert alert-success">
                            <font class="text-success">
                                <i class="fa fa-check"></i> Game successfully added!
                            </font>
                        </div>
                    @endif

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <caption class="title-info">{{ $data->home_team }}</caption>
                                <?php
                                $players = \App\Boxscore::where('game_id',$data->id)
                                    ->where('team',$data->home_team)
                                    ->get();
                                ?>
                                <thead class="bg-success">
                                <tr>
                                    <td>Players</td>
                                    <td>2PT</td>
                                    <td>3PT</td>
                                    <td>FG</td>
                                    <td>FT</td>
                                    <td>OREB</td>
                                    <td>DREB</td>
                                    <td>REB</td>
                                    <td>AST</td>
                                    <td>STL</td>
                                    <td>BLK</td>
                                    <td>TO</td>
                                    <td>PF</td>
                                    <td>PTS</td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $total_fgm = 0;
                                $total_fga = 0;
                                $total_2fm = 0;
                                $total_2fa = 0;
                                $total_3fm = 0;
                                $total_3fa = 0;
                                $total_ftm = 0;
                                $total_fta = 0;
                                $total_oreb =0;
                                $total_dreb = 0;
                                $total_reb = 0;
                                $total_ast = 0;
                                $total_stl = 0;
                                $total_blk = 0;
                                $total_to = 0;
                                $total_pf = 0;
                                $total_pts =0;
                                ?>
                                @foreach($players as $row)
                                    <tr>
                                        <?php
                                        $player = \App\Players::find($row->player_id);
                                        ?>
                                        <td>
                                            <a href="#manualInput" class="btn btn-info btn-xs" data-toggle="modal" data-player="{{ $player->id }}" data-game="{{ $data->id }}">
                                                <i class="fa fa-arrows-alt"></i>
                                            </a>
                                            <a href="{{ url('admin/player/'.$player->id) }}" target="_blank">
                                                {{ $player->fname }} {{ $player->lname }}
                                                <small class="text-muted">{{ $player->position }}</small>
                                            </a>
                                        </td>
                                        <td>
                                            {{ $row->fg2m }}-{{ $row->fg2a }}
                                            <?php
                                            $total_2fm = $total_2fm + $row->fg2m;
                                            $total_2fa = $total_2fa + $row->fg2a;
                                            ?>
                                        </td>
                                        <td>
                                            {{ $row->fg3m }}-{{ $row->fg3a }}
                                            <?php
                                            $total_3fm = $total_3fm + $row->fg3m;
                                            $total_3fa = $total_3fa + $row->fg3a;
                                            ?>
                                        </td>
                                        <td>
                                            {{ $row->fg2m +  $row->fg3m }}-{{ $row->fg2a + $row->fg3a }}
                                            <?php
                                            $total_fgm = $total_fgm + $row->fg2m +  $row->fg3m;
                                            $total_fga = $total_fga + $row->fg2a + $row->fg3a;
                                            ?>
                                        </td>
                                        <td>
                                            {{ $row->ftm }}-{{ $row->fta }}
                                            <?php
                                            $total_ftm = $total_ftm + $row->ftm;
                                            $total_fta = $total_fta + $row->fta;
                                            ?>
                                        </td>
                                        <td>
                                            {{ $row->oreb }}
                                            <?php $total_oreb = $total_oreb + $row->oreb; ?>
                                        </td>
                                        <td>
                                            {{ $row->dreb }}
                                            <?php $total_dreb = $total_dreb + $row->dreb; ?>
                                        </td>
                                        <td>
                                            {{ $row->oreb + $row->dreb }}
                                            <?php $total_reb = $total_reb + $row->oreb + $row->dreb; ?>
                                        </td>
                                        <td>
                                            {{ $row->ast }}
                                            <?php $total_ast = $total_ast + $row->ast; ?>
                                        </td>
                                        <td>
                                            {{ $row->stl }}
                                            <?php $total_stl = $total_stl + $row->stl; ?>
                                        </td>
                                        <td>
                                            {{ $row->blk }}
                                            <?php $total_blk = $total_blk + $row->blk; ?>
                                        </td>
                                        <td>
                                            {{ $row->turnover }}
                                            <?php $total_to = $total_to + $row->turnover; ?>
                                        </td>
                                        <td>
                                            {{ $row->pf }}
                                            <?php $total_pf = $total_pf + $row->pf; ?>
                                        </td>
                                        <td>
                                            {{ $row->pts }}
                                            <?php $total_pts = $total_pts + $row->pts; ?>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="text-warning">
                                    <th>TOTAL</th>
                                    <th>{{ $total_2fm }}-{{$total_2fa }}</th>
                                    <th>{{ $total_3fm }}-{{$total_3fa }}</th>
                                    <th>{{ $total_fgm }}-{{$total_fga }}</th>
                                    <th>{{ $total_ftm }}-{{$total_fta }}</th>
                                    <th>{{ $total_oreb }}</th>
                                    <th>{{ $total_dreb }}</th>
                                    <th>{{ $total_reb }}</th>
                                    <th>{{ $total_ast}}</th>
                                    <th>{{ $total_stl}}</th>
                                    <th>{{ $total_blk}}</th>
                                    <th>{{ $total_to}}</th>
                                    <th>{{ $total_pf}}</th>
                                    <th>{{ $total_pts}}</th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        @if($total_2fa>0)
                                        {{ number_format(($total_2fm / $total_2fa)*100,1) }}%
                                        @else
                                            0.0%
                                        @endif
                                    </td>
                                    <td>
                                        @if($total_3fa>0)
                                        {{ number_format(($total_3fm / $total_3fa)*100,1) }}%
                                        @else
                                            0.0%
                                        @endif
                                    </td>
                                    <td>
                                        @if($total_fga>0)
                                        {{ number_format(($total_fgm / $total_fga)*100,1) }}%
                                        @else
                                            0.0%
                                        @endif
                                    </td>
                                    <td>
                                        @if($total_fta>0)
                                        {{ number_format(($total_ftm / $total_fta)*100,1) }}%
                                        @else
                                            0.0%
                                        @endif
                                    </td>
                                    <td colspan="9"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <caption class="title-info">{{ $data->away_team }}</caption>
                                <?php
                                $players = \App\Boxscore::where('game_id',$data->id)
                                    ->where('team',$data->away_team)
                                    ->get();
                                ?>
                                <thead class="bg-success">
                                <tr>
                                    <td>Players</td>
                                    <td>2PT</td>
                                    <td>3PT</td>
                                    <td>FG</td>
                                    <td>FT</td>
                                    <td>OREB</td>
                                    <td>DREB</td>
                                    <td>REB</td>
                                    <td>AST</td>
                                    <td>STL</td>
                                    <td>BLK</td>
                                    <td>TO</td>
                                    <td>PF</td>
                                    <td>PTS</td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $total_fgm = 0;
                                    $total_fga = 0;
                                    $total_2fm = 0;
                                    $total_2fa = 0;
                                    $total_3fm = 0;
                                    $total_3fa = 0;
                                    $total_ftm = 0;
                                    $total_fta = 0;
                                    $total_oreb =0;
                                    $total_dreb = 0;
                                    $total_reb = 0;
                                    $total_ast = 0;
                                    $total_stl = 0;
                                    $total_blk = 0;
                                    $total_to = 0;
                                    $total_pf = 0;
                                    $total_pts =0;
                                ?>
                                @foreach($players as $row)
                                    <tr>
                                        <?php
                                        $player = \App\Players::find($row->player_id);
                                        ?>
                                        <td>
                                            <a href="#manualInput" class="btn btn-info btn-xs" data-toggle="modal" data-player="{{ $player->id }}" data-game="{{ $data->id }}">
                                                <i class="fa fa-arrows-alt"></i>
                                            </a>
                                            <a href="{{ url('admin/player/'.$player->id) }}" target="_blank">
                                                {{ $player->fname }} {{ $player->lname }}
                                                <small class="text-muted">{{ $player->position }}</small>
                                            </a>
                                        </td>
                                        <td>
                                            {{ $row->fg2m }}-{{ $row->fg2a }}
                                            <?php
                                                $total_2fm = $total_2fm + $row->fg2m;
                                                $total_2fa = $total_2fa + $row->fg2a;
                                            ?>
                                        </td>
                                        <td>
                                            {{ $row->fg3m }}-{{ $row->fg3a }}
                                            <?php
                                                $total_3fm = $total_3fm + $row->fg3m;
                                                $total_3fa = $total_3fa + $row->fg3a;
                                            ?>
                                        </td>
                                        <td>
                                            {{ $row->fg2m +  $row->fg3m }}-{{ $row->fg2a + $row->fg3a }}
                                            <?php
                                                $total_fgm = $total_fgm + $row->fg2m +  $row->fg3m;
                                                $total_fga = $total_fga + $row->fg2a + $row->fg3a;
                                            ?>
                                        </td>
                                        <td>
                                            {{ $row->ftm }}-{{ $row->fta }}
                                            <?php
                                                $total_ftm = $total_ftm + $row->ftm;
                                                $total_fta = $total_fta + $row->fta;
                                            ?>
                                        </td>
                                        <td>
                                            {{ $row->oreb }}
                                            <?php $total_oreb = $total_oreb + $row->oreb; ?>
                                        </td>
                                        <td>
                                            {{ $row->dreb }}
                                            <?php $total_dreb = $total_dreb + $row->dreb; ?>
                                        </td>
                                        <td>
                                            {{ $row->oreb + $row->dreb }}
                                            <?php $total_reb = $total_reb + $row->oreb + $row->dreb; ?>
                                        </td>
                                        <td>
                                            {{ $row->ast }}
                                            <?php $total_ast = $total_ast + $row->ast; ?>
                                        </td>
                                        <td>
                                            {{ $row->stl }}
                                            <?php $total_stl = $total_stl + $row->stl; ?>
                                        </td>
                                        <td>
                                            {{ $row->blk }}
                                            <?php $total_blk = $total_blk + $row->blk; ?>
                                        </td>
                                        <td>
                                            {{ $row->turnover }}
                                            <?php $total_to = $total_to + $row->turnover; ?>
                                        </td>
                                        <td>
                                            {{ $row->pf }}
                                            <?php $total_pf = $total_pf + $row->pf; ?>
                                        </td>
                                        <td>
                                            {{ $row->pts }}
                                            <?php $total_pts = $total_pts + $row->pts; ?>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="text-warning">
                                    <th>TOTAL</th>
                                    <th>{{ $total_2fm }}-{{$total_2fa }}</th>
                                    <th>{{ $total_3fm }}-{{$total_3fa }}</th>
                                    <th>{{ $total_fgm }}-{{$total_fga }}</th>
                                    <th>{{ $total_ftm }}-{{$total_fta }}</th>
                                    <th>{{ $total_oreb }}</th>
                                    <th>{{ $total_dreb }}</th>
                                    <th>{{ $total_reb }}</th>
                                    <th>{{ $total_ast}}</th>
                                    <th>{{ $total_stl}}</th>
                                    <th>{{ $total_blk}}</th>
                                    <th>{{ $total_to}}</th>
                                    <th>{{ $total_pf}}</th>
                                    <th>{{ $total_pts}}</th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        @if($total_2fa>0)
                                            {{ number_format(($total_2fm / $total_2fa)*100,1) }}%
                                        @else
                                            0.0%
                                        @endif
                                    </td>
                                    <td>
                                        @if($total_3fa>0)
                                            {{ number_format(($total_3fm / $total_3fa)*100,1) }}%
                                        @else
                                            0.0%
                                        @endif
                                    </td>
                                    <td>
                                        @if($total_fga>0)
                                            {{ number_format(($total_fgm / $total_fga)*100,1) }}%
                                        @else
                                            0.0%
                                        @endif
                                    </td>
                                    <td>
                                        @if($total_fta>0)
                                            {{ number_format(($total_ftm / $total_fta)*100,1) }}%
                                        @else
                                            0.0%
                                        @endif
                                    </td>
                                    <td colspan="9"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        @if($data->status==0)
                        <hr />
                        <div class="pull-right">
                            <a target="_blank" href="{{ url('admin/games/start/'.$data->id) }}" class="btn btn-success btn-sm">
                                <i class="fa fa-arrows-alt"></i> Start Game
                            </a>
                            <a href="#deleteModal" data-toggle="modal" class="btn btn-default btn-sm">
                                <i class="fa fa-archive"></i> End Game
                            </a>
                        </div>
                        @else
                        <hr />
                        <div class="pull-right">
                            <a href="{{ url('admin/games/refresh/'.$data->id) }}" class="btn btn-warning btn-sm">
                                <i class="fa fa-refresh"></i> Re-Calculate
                            </a>
                        </div>
                        @endif
                </div>
            </div>
        </div>
    </div>
    @include('modal.manualInput')
@endsection

@section('modal')
    <label>END GAME?</label>
    <form method="GET" action="{{ url('admin/games/endgame/'.$data->id) }}">
        <div class="alert alert-warning" style="margin-bottom: 0px;">
            <font class="text-warning">
                <i class="fa fa-warning"></i> Are you sure you want to end the game?
            </font>
        </div>
@endsection

@section('js')
<script>
    $('a[href="#manualInput"]').on('click',function(){
        var game_id = $(this).data('game');
        var player_id = $(this).data('player');

        $('#game_id').val(game_id);
        $('#player_id').val(player_id);

        var url = "{{ url('admin/games/boxscore/stat') }}";
        $.ajax({
            url: url+'/'+game_id+'/'+player_id,
            type: 'GET',
            success: function(data){
                $('#f2m').val(data.fg2m);
                $('#f2a').val(data.fg2a);
                $('#f3m').val(data.fg3m);
                $('#f3a').val(data.fg3a);
                $('#ftm').val(data.ftm);
                $('#fta').val(data.fta);
                $('#oreb').val(data.oreb);
                $('#dreb').val(data.dreb);
                $('#ast').val(data.ast);
                $('#stl').val(data.stl);
                $('#blk').val(data.blk);
                $('#turnover').val(data.turnover);
                $('#pf').val(data.pf);
                $('#pts').val(data.pts);
            }
        });
    });

    function calculate(){
        var pt1 = $('#ftm').val();
        var pt2 = $('#f2m').val();
        var pt3 = $('#f3m').val();

        pt1 = pt1*1;
        pt2 = pt2*2;
        pt3 = pt3*3;

        $('#pts').val(pt1+pt2+pt3);
    }
</script>
@endsection

