{{--<vue-form form-action="{{ $formAction }}" :is-update="{{ var_export($isUpdate ?? false, true) }}">--}}
<vue-form form-action="{{ $formAction }}" redirect-url="{{ $redirectUrl or null }}" text-submit="{{ empty($isUpdate) ? __('forms.actions.create') : __('forms.actions.save') }}">
    {{--{{ csrf_field() }}--}}

    {{ $methodField or null }}

    {{ $slot }}
</vue-form>