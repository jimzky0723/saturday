@extends('layouts.guest')
@section('content')
    <div class="news">
        <div class="col-md-9">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3>Unavailable</h3>
                </div>
                <div class="box-body">
                    <div class="alert alert-warning">
                        <span class="text-warning">
                            <i class="fa fa-warning"></i> This page is under maintenance!
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        @include('sidebar.player')
    </div>
@endsection

@section('js')

@endsection

