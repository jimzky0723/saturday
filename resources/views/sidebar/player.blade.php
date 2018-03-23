<?php
    $top = \App\Http\Controllers\ParamCtrl::getTopPlayer();
    $player_id = $top->player_id;
    $player = \App\Players::find($player_id);
?>
<div class="panel panel-jim">
    <div class="panel-heading">
        <h3 class="panel-title">Rank 1 Overall Statistics</h3>
    </div>
    <div class="panel-body">
        <div class="thumbnail img-responsive">
            <img src="{{ url('public/upload/portrait/'.$player->portrait_pic) }}" />
            <div class="text-center">
                <span class="title-info">{{ $player->fname }} {{ $player->lname }}</span>
                <br />
                <small class="text-muted">Average of {{ number_format($top->pts,1) }} PPG, {{ number_format($top->ast,1) }} APG, {{ number_format($top->reb,1) }} RPG</small>
            </div>

        </div>

    </div>
</div>

<div class="panel panel-jim">
    <div class="panel-heading">
        <h3 class="panel-title">Committee of the Week</h3>
    </div>
    <div class="panel-body">
        <div class="list-group">
            <a href="#" class="list-group-item clearfix">
                <img src="{{ url('public/upload/profile/Wairley VonCCabiluna19901210.png') }}" height="40px">
                <span class="text-success">Wairley Von Cabiluna</span>
            </a>
            <a href="#" class="list-group-item clearfix">
                <img src="{{ url('public/upload/profile/JeswyrneDGonzales19960912.png') }}" height="40px">
                <span class="text-success">Jeswyrne Gonzales</span>
            </a>
            <a href="#" class="list-group-item clearfix">
                <img src="{{ url('public/upload/profile/JimmyBaronLomocso19900923.png') }}" height="40px">
                <span class="text-success">Jimmy Lomocso</span>
            </a>
            <a href="#" class="list-group-item clearfix">
                <img src="{{ url('public/upload/profile/RuselTTayong19950223.png') }}" height="40px">
                <span class="text-success">Rusel Tayong</span>
            </a>
        </div>

    </div>
</div>