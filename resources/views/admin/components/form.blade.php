<vue-form form-action="{{ $formAction }}">
    {{--{{ csrf_field() }}--}}

    {{ $slot }}
</vue-form>