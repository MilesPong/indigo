<div class="navbar-fixed">
    <nav id="nav-bar" class="z-depth-0">
        <div class="nav-wrapper container">
            <a href="/" class="brand-logo"><i class="material-icons">camera</i>Indigo</a>
            <a href="#" data-activates="mobile-nav" class="button-collapse"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <!-- Dropdown Trigger -->
                <li>
                    <a class="dropdown-button" href="#!" data-activates="cate-dropdown">
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
<ul class="side-nav" id="mobile-nav">
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li>
                <a class="collapsible-header">Category</a>
                <div class="collapsible-body">
                    <ul>
                        @foreach($categories as $category)
                            <li><a class="waves-effect waves-teal" href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </li>
        </ul>
    </li>
    <li><a class="waves-effect waves-teal" href="#!">About</a></li>
    <li><a class="waves-effect waves-teal" href="https://github.com/MilesPong">Github</a></li>
</ul>

<!-- Dropdown Structure -->
<ul id="cate-dropdown" class="dropdown-content">
    @foreach($categories as $category)
        <li><a class="waves-effect waves-teal" href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a></li>
    @endforeach
</ul>

@push('js')
<script>
    $(function () {
        $(".button-collapse").sideNav();

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