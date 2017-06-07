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
                @if(request()->has('trash'))
                    <form action="{{ route('admin.posts.restore', $post->id) }}" method="POST" style="display: inline;">
                        {{ csrf_field() }}
                        <button type='submit' class="btn btn-success">Restore</button>
                    </form>
                    <form action="{{ route('admin.posts.force-delete', $post->id) }}" method="POST" style="display: inline;">
                        {{ csrf_field() }}
                        <button type='submit' class="btn btn-danger">Force Delete</button>
                    </form>
                @else
                    <a class="btn btn-success" href="{{ route('admin.posts.show', $post->id) }}">View</a>
                    <a class="btn btn-primary" href="{{ route('admin.posts.edit', $post->id) }}">Edit</a>
                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" style="display: inline;">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type='submit' class="btn btn-danger">Delete</button>
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="pull-right">
    {{ $posts->links() }}
</div>