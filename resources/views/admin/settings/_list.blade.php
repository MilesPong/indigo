<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>ID</th>
        <th>Key</th>
        <th>Value</th>
        <th>Tag</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($settings as $setting)
        <tr>
            <td>{{ $setting->id }}</td>
            <td>{{ $setting->key }}</td>
            <td>{{ $setting->value }}</td>
            <td>{{ $setting->tag }}</td>
            <td>
                <a class="btn btn-primary" href="{{ route('admin.settings.edit', $setting->id) }}">Edit</a>
                <form action="{{ route('admin.settings.destroy', $setting->id) }}" method="POST" style="display: inline;">
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
    {{ $settings->links() }}
</div>