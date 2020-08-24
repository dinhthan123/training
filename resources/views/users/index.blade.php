@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Users</div>

        <div class="panel-body table-responsive">
            <router-view></router-view>
        </div>
    </div>
@endsection
