@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">

            <!-- general form elements disabled -->
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Role Info</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <form role="form" action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                        {{ method_field('PATCH') }}

                        @include('admin.roles._form')

                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection