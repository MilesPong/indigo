@if(Session::has('success'))
    @component('admin.components.alerts.dismissible', ['title' => 'success'])
        @slot('type')
            success
        @endslot
        {{ Session::get('success') }}
    @endcomponent
@endif

@if(Session::has('errors'))
    @component('admin.components.alerts.dismissible', ['title' => 'error'])
        @slot('type')
            danger
        @endslot
        @if(count($errors) > 1)
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @else
            {{ $errors->first() }}
        @endif
    @endcomponent
@endif