@extends('admin.layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements disabled -->
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Post Info</h3>
                </div>
                <!-- /.box-header -->
                <form role="form" action="{{ route('posts.update', $post->id) }}" method="POST" class="form-horizontal">
                <div class="box-body">
                    {{ method_field('PATCH') }}
                    @include('admin.posts._form')
                </div>
                <!-- /.box-body -->
                @stack('box-footer')
                <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection