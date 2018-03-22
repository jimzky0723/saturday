<div class="panel panel-jim">
    <div class="panel-heading">
        <h3 class="panel-title">Player Profile</h3>
    </div>
    <div class="panel-body">
        <div class="thumbnail img-responsive">
            <img src="{{ url('public/upload/portrait/'.$data->portrait_pic) }}" />
            <div class="text-center">
                <span class="title-info">{{ $data->fname }} {{ $data->lname }}
                <br />
                <small class="text-muted">
                    #{{ $data->jersey }} | {{ $data->height }}, {{ $data->weight }}<br />
                    {{ $data->section }}
                </small>
                </span>
            </div>

        </div>

    </div>
</div>
<style>
    .table-stat tr td:first-child {
        background: #111;
        color: #fff;
        text-align: right;
        vertical-align: middle;
        font-weight: bold;
        padding: 5px;
        width:40%;
    }

    .table-stat tr td:nth-child(2) {
        color: #443ff5;
        vertical-align: middle;
        font-weight: bold;
        padding: 5px;
    }

    .table-stats tr td {
        border:1px solid #bbb !important;
    }
</style>
<div class="panel panel-jim">
    <div class="panel-heading">
        <h3 class="panel-title">2018 Career</h3>
    </div>
    <div class="panel-body">
        <table class="table table-stat" style="margin-bottom: 0px;">
            <tr>
                <td>PPG</td>
                <td>13.2</td>
            </tr>
            <tr>
                <td>APG</td>
                <td>5.3</td>
            </tr>
            <tr>
                <td>RPG</td>
                <td>3.2</td>
            </tr>
        </table>
    </div>
</div>