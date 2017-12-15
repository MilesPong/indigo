{{--<vue-form form-action="{{ $formAction }}" :is-update="{{ var_export($isUpdate ?? false, true) }}">--}}
<vue-form form-action="{{ $formAction }}">
    {{--{{ csrf_field() }}--}}

    {{ $methodField or null }}

    {{ $slot }}
</vue-form>