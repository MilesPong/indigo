<vue-select
        name="{{ $name }}"
        label="{{ $label }}"
        :is-multiple="{{ var_export($isMultiple ?? false, true) }}"
        selected='{!! json_encode(isset($selected) ? (is_array($selected) ? $selected : [$selected]) : []) !!}'
>
    {{ $slot }}
</vue-select>