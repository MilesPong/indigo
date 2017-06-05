@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">

            <!-- general form elements disabled -->
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">User Info</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <form role="form" action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        {{ method_field('PATCH') }}

                        @include('admin.users._form')

                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection