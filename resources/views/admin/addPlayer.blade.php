@extends('layouts.app')

@section('content')
    <?php
        $status = session('status');
        $player_id = 0;
        $str = date('mdHis');
        $unique_id = '';
        $fname = '';
        $mname = '';
        $lname = '';
        $dob = '';
        $position = '';
        $jersey = '';
        $height = '';
        $weight = '';
        $section = '';
        $prof_pic = 'prof_default.jpg?image='.$str;
        $portrait_pic = 'portrait_default.jpg?image='.$str;
        $stat = 0;

        if(isset($data))
        {
            $player_id = $data->id;
            $unique_id = $data->unique_id;
            $fname = $data->fname;
            $mname = $data->mname;
            $lname = $data->lname;
            $dob = $data->dob;
            $position = $data->position;
            $jersey = $data->jersey;
            $height = $data->height;
            $weight = $data->weight;
            $section = $data->section;
            $prof_pic = 'profile/'.$data->prof_pic.'?image='.$str;
            $portrait_pic = 'portrait/'.$data->portrait_pic.'?image='.$str;
            $stat = $data->status;
        }
        $url = url('admin/player/update');
        if($title=='Add Player')
        {
            $url = url('admin/player/store');
        }
    ?>
    <style>
        .table-input tr td:first-child {
            background: #f5f5f5;
            text-align: right;
            vertical-align: middle;
            font-weight: bold;
            padding: 3px;
            width:30%;
        }
        .table-input tr td {
            border:1px solid #bbb !important;
        }
    </style>
    <div class="col-md-9">
        <div class="jim-content">
            <h3 class="page-header">
                {{ $title }}</h3>
            <div class="row">
                <div class="col-md-12">
                    @if($status=='saved')
                    <div class="alert alert-success">
                        <font class="text-success">
                            <i class="fa fa-check"></i> 1 player successfully added!
                        </font>
                    </div>
                    @endif

                    @if($status=='updated')
                        <div class="alert alert-success">
                            <font class="text-success">
                                <i class="fa fa-check"></i> Player successfully updated!
                            </font>
                        </div>
                    @endif

                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Personal Information</a></li>
                        <li role="presentation"><a href="#stats" aria-controls="history" role="tab" data-toggle="tab">Stats</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">
                            <br />
                            <form method="POST" class="form-horizontal form-submit" enctype="multipart/form-data" id="form-submit" action="{{ $url }}">
                                {{ csrf_field() }}
                                <input type="hidden" value="{{ $unique_id }}" name="unique_id"/>
                                <table class="table-input table table-bordered table-hover" border="1">
                                    <tr class="has-group">
                                        <td>First Name :</td>
                                        <td><input type="text" value="{{ $fname }}" name="fname" class="fname form-control" required /> </td>
                                    </tr>
                                    <tr>
                                        <td>Middle Name :</td>
                                        <td><input type="text" value="{{ $mname }}" name="mname" class="mname form-control" /> </td>
                                    </tr>
                                    <tr class="has-group">
                                        <td>Last Name :</td>
                                        <td><input type="text" value="{{ $lname }}" name="lname" class="lname form-control" required /> </td>
                                    </tr>
                                    <tr class="has-group">
                                        <td>Birth Date :</td>
                                        <td><input type="date"  value="{{ $dob }}" name="dob" class="form-control dob" required /> </td>
                                    </tr>
                                    <tr class="has-group">
                                        <td>Position :</td>
                                        <td>
                                            <select name="position" class="form-control" required>
                                                <option {{ ($position=='PG') ? 'selected': '' }} value="PG">Point Guard</option>
                                                <option {{ ($position=='SG') ? 'selected': '' }} value="SG">Shooting Guard</option>
                                                <option {{ ($position=='SF') ? 'selected': '' }} value="SF">Small Forward</option>
                                                <option {{ ($position=='PF') ? 'selected': '' }} value="PF">Power Forward</option>
                                                <option {{ ($position=='C') ? 'selected': '' }} value="C">Center</option>
                                                <option {{ ($position=='PG/SG') ? 'selected': '' }} value="PG/SG">Point/Shooting Guard</option>
                                                <option {{ ($position=='SG/SF') ? 'selected': '' }} value="SG/SF">Shooting Guard/Small Forward</option>
                                                <option {{ ($position=='SF/PF') ? 'selected': '' }} value="SF/PF">Small/Power Forward</option>
                                                <option {{ ($position=='PF/C') ? 'selected': '' }} value="PF/C">Power Forward/Center</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="has-group">
                                        <td>Jersey No. :</td>
                                        <td><input type="text" value="{{ $jersey }}" name="jersey" class="lname form-control" required /> </td>
                                    </tr>
                                    <tr class="has-group">
                                        <td>Height (ft):</td>
                                        <td><input type="text" value="{{ $height }}" name="height" class="lname form-control" /> </td>
                                    </tr>
                                    <tr class="has-group">
                                        <td>Weight (lbs) :</td>
                                        <td><input type="text" value="{{ $weight }}" name="weight" class="lname form-control" /> </td>
                                    </tr>
                                    <tr class="has-group">
                                        <td>Section :</td>
                                        <td><input type="text" value="{{ $section}}" name="section" class="lname form-control" /> </td>
                                    </tr>
                                    <tr class="has-group">
                                        <td>Profile Picture :</td>
                                        <td><input type="file" name="prof_pic" class="form-control" accept="image/png" onchange="readProfURL(this);" /> </td>
                                    </tr>
                                    <tr class="has-group">
                                        <td>Portrait Picture :</td>
                                        <td><input type="file" name="portrait_pic" class="lname form-control" accept="image/png" onchange="readPortraitURL(this);" /> </td>
                                    </tr>
                                    <tr class="has-group">
                                        <td>Status :</td>
                                        <td>
                                            <select name="status" class="form-control">
                                                <option {{ ($stat==0) ? 'selected': '' }} value="0">Unregistered</option>
                                                <option {{ ($stat==1) ? 'selected': '' }} value="1">Registered</option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td>
                                            <a href="{{ asset('admin/players') }}" class="btn btn-sm btn-default">
                                                <i class="fa fa-arrow-left"></i> Back
                                            </a>
                                            @if($title=='Add Player')
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fa fa-send"></i> Save
                                                </button>
                                            @else
                                                <button data-target="#deleteModal" data-toggle="modal" type="button" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fa fa-pencil"></i> Update
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="stats">
                            <br />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        @include('sidebar.addPlayer')
    </div>
@endsection

@section('modal')
    <label>DELETE PLAYER?</label>
    <form method="GET" action="{{ url('admin/player/destroy/'.$player_id) }}">
        <div class="alert alert-warning" style="margin-bottom: 0px;">
            <font class="text-warning">
                <i class="fa fa-warning"></i> Are you sure you want to delete this player? All records corresponding to this player will be deleted.
            </font>
        </div>
@endsection

@section('js')
    <script>
        function readProfURL(input)
        {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#prof_pic').attr('src', e.target.result);
                    $('#prof_pic').addClass('img-responsive');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readPortraitURL(input)
        {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#portrait_pic').attr('src', e.target.result);
                    $('#portrait_pic').addClass('img-responsive');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection

