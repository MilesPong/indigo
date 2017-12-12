{{-- NavBar --}}
<div class="navbar-fixed">
    <nav id="nav-bar" class="z-depth-0">
        <div class="nav-wrapper container">
            {{-- Only for large screen --}}
            <a href="#" data-target="slide-out" class="sidenav-trigger hide-on-med-and-down menu-on-large"><i class="material-icons">menu</i></a>

            {{-- Normal usage --}}
            <a href="#" data-target="slide-out" class="sidenav-trigger button-collapse hide-on-large-only"><i class="material-icons">menu</i></a>

            <a href="/" class="brand-logo"><i class="material-icons">camera</i>Indigo</a>
            <ul class="right hide-on-med-and-down">
                <!-- Dropdown Trigger -->
                <li>
                    <a class="dropdown-trigger" href="#!" data-target="cate-dropdown">
                        Category
                        <i class="material-icons right">arrow_drop_down</i>
                    </a>
                </li>

                <li><a class="waves-effect waves-light" href="#!">About</a></li>
                <li><a class="waves-effect waves-light" href="https://github.com/MilesPong">Github</a></li>
            </ul>

        </div>
    </nav>
</div>

<!-- Dropdown Structure -->
<ul id="cate-dropdown" class="dropdown-content">
    @foreach($categories as $category)
        <li><a class="waves-effect waves-teal" href="{{ route('categories.show', $category->slug) }}">{{ $category->name }}</a></li>
    @endforeach
</ul>

@push('js')
<script>
    $(function () {
        $(".dropdown-trigger").dropdown();

        $(window).scroll(function () {
            var nav = $("#nav-bar");
            var scroll = $(window).scrollTop();
            if (scroll > 0) {
                nav.removeClass("z-depth-0");
                nav.addClass("z-depth-2");
            }
            else {
                nav.removeClass("z-depth-2");
                nav.addClass("z-depth-0");
            }
        });
    })
</script>
@endpush