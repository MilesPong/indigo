{{-- Table --}}
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
             <td>{{ $item->$field ?: Indigo\Tools\EloquentPresenter::parseRelationship($item, $field)}}</td>
        @endforeach

            <td>
                @if (!empty($hrefShow) && empty($showTrash))
                    <vue-table-action link="{{ $hrefShow }}" identifier="{{ $item->id }}" icon="visibility"></vue-table-action>
                @endif

                @if (!empty($hrefEdit) && empty($showTrash))
                    <vue-table-action link="{{ $hrefEdit }}" identifier="{{ $item->id }}" class="blue" icon="mode_edit"></vue-table-action>
                @endif

                @if (!empty($hrefDestroy) && empty($showTrash))
                    <vue-table-action link="{{ $hrefDestroy }}" identifier="{{ $item->id }}" class="red" icon="delete" is-destroy></vue-table-action>
                @endif

                @if (!empty($hrefForceDelete) && !empty($showTrash))
                    <vue-table-action link="{{ $hrefForceDelete }}" identifier="{{ $item->id }}" class="red" icon="delete_forever" is-destroy></vue-table-action>
                @endif

                @if (!empty($hrefRestore) && !empty($showTrash))
                    <vue-table-action link="{{ $hrefRestore }}" identifier="{{ $item->id }}" class="indigo" icon="refresh" is-restore></vue-table-action>
                @endif

                {{ $additional_action or null }}
            </td>

        </tr>
    @endforeach

    </tbody>
</table>

{{-- Pagination --}}
<div class="center-align">
    {{ $paginator->appends(request()->query())->links('vendor.pagination.materialize') }}
</div>

{{-- FAB --}}
@component('admin.components.fab', [
    'link' => $hrefCreate ?? null,
    'icon' => $iconCreate ?? null,
    'color' => $iconColor ?? null
])
    {{ $fab or null }}
@endcomponent