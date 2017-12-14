<table class="striped highlight responsive-table">
    <thead>
        <tr>
            @foreach ($columns as $field => $displayName)
                <th>{{ $displayName }}</th>
            @endforeach

            <th>Action</th>
        </tr>
    </thead>

    <tbody>

    @foreach ($paginator as $item)
        <tr>

        @foreach ($columns as $field => $displayName)
             <td>{{ $item->$field }}</td>
        @endforeach

            <td>
                @if (isset($hrefShow))
                    <a class="btn-floating waves-effect waves-light" href="{{ $hrefShow }}">
                        <i class="material-icons">visibility</i>
                    </a>
                @endif

                @if (isset($hrefEdit))
                    <a class="btn-floating waves-effect waves-light blue" href="{{ $hrefEdit }}">
                        <i class="material-icons">mode_edit</i>
                    </a>
                @endif

                @if (isset($hrefDestroy))
                    <a class="btn-floating waves-effect waves-light red" href="{{ $hrefDestroy }}">
                        <i class="material-icons">delete</i>
                    </a>
                @endif

                {{ $additional_action or null }}
            </td>

        </tr>
    @endforeach

    </tbody>
</table>

<div class="center-align">
    {{ $paginator->links('vendor.pagination.materialize') }}
</div>