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
                    <vue-table-action link="{{ $hrefShow }}" identifier="{{ $item->id }}" icon="visibility"></vue-table-action>
                @endif

                @if (isset($hrefEdit))
                    <vue-table-action link="{{ $hrefEdit }}" identifier="{{ $item->id }}" class="blue" icon="mode_edit"></vue-table-action>
                @endif

                @if (isset($hrefDestroy))
                    <vue-table-action link="{{ $hrefDestroy }}" identifier="{{ $item->id }}" class="red" icon="delete"></vue-table-action>
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