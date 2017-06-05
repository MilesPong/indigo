@extends('admin.layouts.app')

@section('content')
    <a href="{{ route('admin.roles.create') }}" class="btn btn-lg btn-primary btn-flat" style="margin-bottom: 15px;">Add New</a>

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Hover Data Table</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Display Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->display_name }}</td>
                                <td>{{ str_limit($role->description, 20) }}</td>
                                <td>
                                    <a class="btn btn-success" href="{{ route('admin.roles.show', $role->id) }}">View</a>
                                    <a class="btn btn-primary" href="{{ route('admin.roles.edit', $role->id) }}">Edit</a>
                                    <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" style="display: inline;">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type='submit' class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="pull-right">
                        {{ $roles->links() }}
                    </div>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </div>
        <!-- /.col -->
    </div>


@endsection