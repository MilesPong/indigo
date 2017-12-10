<div class="navbar-fixed">
    <nav id="nav-bar" class="z-depth-0">
        <div class="nav-wrapper container">
            <a href="#" data-activates="slide-out" class="btn-profile hide-on-med-and-down"><i class="material-icons">menu</i></a>
            <a href="/" class="brand-logo"><i class="material-icons">camera</i>Indigo</a>
            <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
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

<!-- Dropdown Structure -->
<ul id="cate-dropdown" class="dropdown-content">
    @foreach($categories as $category)
        <li><a class="waves-effect waves-teal" href="{{ route('categories.show', $category->slug) }}">{{ $category->name }}</a></li>
    @endforeach
</ul>

<ul id="slide-out" class="side-nav">
    <li>
        <div class="user-view">
            <div class="background">
                <img src="{{ asset('images/office.jpg') }}">
            </div>
            <a href="#!user"><img class="circle" src="{{ asset('images/avatar.jpg') }}"></a>
            <a href="#!name"><span class="white-text name">Miles Peng</span></a>
            <a href="mailto:mingpeng16@gmail.com"><span class="white-text email">mingpeng16@gmail.com</span></a>
        </div>
    </li>
    <li>
        <ul class="collapsible collapsible-accordion">
            <li>
                <div class="collapsible-header"><i class="material-icons">apps</i>Category</div>
                <div class="collapsible-body grey lighten-4">
                    <ul>
                        @foreach($categories as $category)
                        <li>
                            <a class="waves-effect waves-teal" href="{{ route('categories.show', $category->slug) }}">
                                <span class="badge teal white-text">{{ $category->posts_count }}</span>
                                {{ $category->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </li>
        </ul>
    </li>
    <li><div class="divider"></div></li>
    {{--<li><a class="subheader">Subheader</a></li>--}}
    <li><a href="#!" class="waves-effect waves-teal"><i class="material-icons">cloud</i>Blog Introduce</a></li>
    <li><a class="waves-effect waves-teal" href="#!"><i class="material-icons">person</i>About</a></li>
    <li><a class="waves-effect waves-teal" href="https://github.com/MilesPong"><i class="material-icons">code</i>Github</a></li>
</ul>

@push('js')
<script>
    $(function () {
        $(".button-collapse").sideNav();

        // TODO Can't set sideNav() at the same time?, hack
        if ($(window).width() > 992) {
            // Initialize collapse button
            $(".btn-profile").sideNav();
        }

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