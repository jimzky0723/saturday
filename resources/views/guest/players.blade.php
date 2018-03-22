@extends('layouts.guest')
@section('content')
    <div class="news">
        <div class="col-md-9">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3>Players</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr class="bg-black">
                                <th>NO.</th>
                                <th>NAME</th>
                                <th>POS</th>
                                <th>AGE</th>
                                <th>HT</th>
                                <th>WT</th>
                                <th>SECTION</th>
                            </tr>
                            @foreach($data as $row)
                                <tr>
                                    <td class="title-info">{{ $row->jersey }}</td>
                                    <td class="title-info">
                                        <a href="{{ url('player/'.$row->id) }}" rel="popover" data-img="{{ asset('public/upload/profile/'.$row->prof_pic.'?img='.date('YmdHis')) }}">
                                            {{ $row->lname }}, {{ $row->fname }} {{ $row->mname }}
                                        </a>
                                    </td>
                                    <td>{{ $row->position }}</td>
                                    <td>{{ \App\Http\Controllers\ParamCtrl::getAge($row->dob) }}</td>
                                    <td>{{ $row->height }}</td>
                                    <td>{{ $row->weight }}</td>
                                    <td>{{ $row->section }}</td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="text-center">
                            {{ $data->links() }}
                        </div>
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

