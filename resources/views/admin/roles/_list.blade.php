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