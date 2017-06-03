<div class="alert alert-{{ $type }} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4>
        <i class="icon fa fa-ban"></i>
        @if(isset($title))
            {{ ucfirst($title) }}
        @endif
    </h4>

    {{ $slot }}
</div>