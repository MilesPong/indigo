@extends('admin.layouts.admin')

@section('content')
    <a href="{{ route('posts.create') }}" class="btn btn-lg btn-primary btn-flat" style="margin-bottom: 15px;">Add New</a>

    <div class="row">
        <div class="col-xs-12">

            <div class="box box-default">
                <div class="box-body">
                    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->author->name }}</td>
                                <td>{{ $post->category->name }}</td>
                                <td>{{ $post->created_at }}</td>
                                <td>
                                    <a class="btn btn-success" href="{{ route('posts.show', $post->id) }}">View</a>
                                    <a class="btn btn-primary" href="{{ route('posts.edit', $post->id) }}">Edit</a>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display: inline;">
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
                        {{ $posts->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection