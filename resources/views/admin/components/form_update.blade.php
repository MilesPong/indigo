@component('admin.components.form_base', ['formAction' => $formAction])

    @slot('methodField')
        {{ method_field('PATCH') }}
    @endslot

    {{ $slot }}

@endcomponent