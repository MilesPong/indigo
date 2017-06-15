<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>Name</th>
        <th>Display Name</th>
        <th>Description</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($permissions as $permission)
        <tr>
            <td>{{ $permission->name }}</td>
            <td>{{ $permission->display_name }}</td>
            <td>{{ str_limit($permission->description, 20) }}</td>
            <td>
                <a class="btn btn-success" href="{{ route('admin.permissions.show', $permission->id) }}">View</a>
                <a class="btn btn-primary" href="{{ route('admin.permissions.edit', $permission->id) }}">Edit</a>
                <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" style="display: inline;">
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
    {{ $permissions->links() }}
</div>