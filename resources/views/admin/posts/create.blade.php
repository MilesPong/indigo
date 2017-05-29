@extends('admin.layouts.admin')

@inject('post', 'App\Models\Post')

@section('content')
    <div class="row">
        <div class="col-md-12">

            <!-- general form elements disabled -->
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Post Info</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <form role="form" action="{{ route('posts.store') }}" method="POST">

                        @include('admin.posts._form')

                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection