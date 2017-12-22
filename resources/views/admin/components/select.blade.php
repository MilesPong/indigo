<vue-select
        name="{{ $name }}"
        label="{{ $label }}"
        :is-multiple="{{ var_export($isMultiple ?? false, true) }}"
        selected="{!! json_encode($selected ?? []) !!}"
>
    {{ $slot }}
</vue-select>