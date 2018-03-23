@component('admin.components.form_base', ['formAction' => $formAction, 'isUpdate' => true])

    @slot('methodField')
        {{ method_field('PATCH') }}
    @endslot

    {{ $slot }}

@endcomponent