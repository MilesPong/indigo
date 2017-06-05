@extends('admin.layouts.app')

@section('content')
    <a href="{{ route('admin.tags.create') }}" class="btn btn-lg btn-primary btn-flat" style="margin-bottom: 15px;">Add New</a>

    <div class="row">
        <div class="col-xs-12">

            <div class="box box-default">
                <div class="box-body">
                    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Slug</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tags as $tag)
                            <tr>
                                <td>{{ $tag->name }}</td>
                                <td>{{ $tag->description }}</td>
                                <td>{{ $tag->slug }}</td>
                                <td>
                                    <a class="btn btn-success" href="{{ route('admin.tags.show', $tag->id) }}">View</a>
                                    <a class="btn btn-primary" href="{{ route('admin.tags.edit', $tag->id) }}">Edit</a>
                                    <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST" style="display: inline;">
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
                        {{ $tags->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection