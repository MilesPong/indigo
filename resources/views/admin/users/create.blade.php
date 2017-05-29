@extends('admin.layouts.admin')

@inject('user', 'App\Models\User')

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

                    <form role="form" action="{{ route('users.store') }}" method="POST">

                        @include('admin.users._form')

                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection