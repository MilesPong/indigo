{{-- Languages --}}
<ul id='lang-dropdown' class='dropdown-content'>
    @foreach($localeLinks as $localeName => $link)
        <li><a href="{{ $link }}">{{ $localeName }}</a></li>
    @endforeach
</ul>