{{-- NavBar --}}
<div class="navbar-fixed">
    <nav id="nav-bar" class="z-depth-0">
        <div class="nav-wrapper container">
            {{-- Only for large screen --}}
            <a href="#" data-target="slide-out" class="sidenav-trigger hide-on-med-and-down menu-on-large"><i class="material-icons">menu</i></a>

            {{-- Normal usage --}}
            <a href="#" data-target="slide-out" class="sidenav-trigger button-collapse hide-on-large-only"><i class="material-icons">menu</i></a>

            <a href="/" class="brand-logo"><i class="material-icons hide-on-small-and-down">home</i>{{ setting('title', config('app.name', 'Laravel')) }}</a>
            <ul class="right hide-on-med-and-down">

                <li>
                    <!-- Search bar -->
                    <form action="{{ route('search') }}">
                        <div class="input-field">
                            <input id="search" type="search" name="q" required>
                            <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                            <i class="material-icons">close</i>
                        </div>
                    </form>
                </li>

                <!-- Dropdown Trigger -->
                <li>
                    <a class="dropdown-trigger" href="#!" data-target="cate-dropdown">
                        @lang('menus.categories')
                        <i class="material-icons right">arrow_drop_down</i>
                    </a>
                </li>

                <li><a class="waves-effect waves-light" href="{{ route('pages.show', 'about') }}">@lang('menus.about')</a></li>
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