<div class="fixed-action-btn">
    <a class="btn-floating btn-large red" href="{{ $link or '#!' }}">
        <i class="large material-icons">{{ $icon or 'add' }}</i>
    </a>

    {{ $slot }}

    {{--<ul>--}}
        {{--<li><a class="btn-floating red"><i class="material-icons">insert_chart</i></a></li>--}}
        {{--<li><a class="btn-floating yellow darken-1"><i class="material-icons">format_quote</i></a></li>--}}
        {{--<li><a class="btn-floating green"><i class="material-icons">publish</i></a></li>--}}
        {{--<li><a class="btn-floating blue"><i class="material-icons">attach_file</i></a></li>--}}
    {{--</ul>--}}
</div>

@push('js')
    <script>
        new M.FloatingActionButton(document.querySelector('.fixed-action-btn'));
    </script>
@endpush