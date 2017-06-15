@extends('admin.layouts.app')

@section('content')
    <a href="{{ route('admin.posts.create') }}" class="btn btn-lg btn-primary btn-flat" style="margin-bottom: 15px;">Add New</a>

    @if(request()->has('trash'))
        <a href="{{ route('admin.posts.index') }}" class="btn btn-lg btn-warning btn-flat pull-right" style="margin-bottom: 15px;">All</a>
    @else
        <a href="{{ route('admin.posts.index', ['trash' => 'true']) }}" class="btn btn-lg btn-warning btn-flat pull-right" style="margin-bottom: 15px;">Trash</a>
    @endif

    <div class="row">
        <div class="col-xs-12">

            <div class="box box-default">
                <div class="box-body">
                    @include('admin.posts._list')
                </div>
            </div>
        </div>
    </div>

@endsection