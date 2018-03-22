@extends('layouts.guest')
@section('content')
    <style>
        .table-stats {
            font-size: 0.8em;
            font-weight: normal !important;
        }
    </style>
    <div class="col-md-3">
        @include('sidebar.profile')
    </div>
    <div class="news">
        <div class="col-md-9">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h4>Stats</h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-stats table-striped table-hover">
                            <tr class="bg-black">
                                <th></th>
                                <th>GP</th>
                                <th>FGM-FGA</th>
                                <th>FG%</th>
                                <th>3PM-3PA</th>
                                <th>3P%</th>
                                <th>FTM-FTA</th>
                                <th>FT%</th>
                                <th>APG</th>
                                <th>RPG</th>
                                <th>BLKPG</th>
                                <th>STLPG</th>
                                <th>PFPG</th>
                                <th>TOPG</th>
                                <th>PPG</th>
                            </tr>
                            <tr>
                                <th>2018 Season</th>
                                <th>3</th>
                                <th>8-20</th>
                                <th>40%</th>
                                <th>2-7</th>
                                <th>0.28</th>
                                <th>5-10</th>
                                <th>50%</th>
                                <th>3.5</th>
                                <th>2.5</th>
                                <th>0.2</th>
                                <th>0.5</th>
                                <th>1.3</th>
                                <th>2.3</th>
                                <th>7.3</th>
                            </tr>
                            <tr>
                                <th>Career</th>
                                <th>3</th>
                                <th>8-20</th>
                                <th>40%</th>
                                <th>2-7</th>
                                <th>0.28</th>
                                <th>5-10</th>
                                <th>50%</th>
                                <th>3.5</th>
                                <th>2.5</th>
                                <th>0.2</th>
                                <th>0.5</th>
                                <th>1.3</th>
                                <th>2.3</th>
                                <th>7.3</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="box box-success">
                <div class="box-header with-border">
                    <h4>Game Log</h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-stats table-striped table-hover">
                            <tr class="bg-black">
                                <th>DATE</th>
                                <th>OPP</th>
                                <th>SCORE</th>
                                <th>FGM-FGA</th>
                                <th>FG%</th>
                                <th>3PM-3PA</th>
                                <th>3P%</th>
                                <th>FTM</th>
                                <th>FTA</th>
                                <th>FT%</th>
                                <th>REB</th>
                                <th>AST</th>
                                <th>BLK</th>
                                <th>STL</th>
                                <th>PF</th>
                                <th>TO</th>
                                <th>PTS</th>
                            </tr>
                            <tr>
                                <th>03/19</th>
                                <th>Team B</th>
                                <th>
                                    <span class="text-danger">L</span> 20-8
                                </th>
                                <th>0-3</th>
                                <th>0%</th>
                                <th>1-4</th>
                                <th>25%</th>
                                <th>0</th>
                                <th>0</th>
                                <th>0%</th>
                                <th>3</th>
                                <th>1</th>
                                <th>0</th>
                                <th>0</th>
                                <th>2</th>
                                <th>7</th>
                                <th>3</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection

