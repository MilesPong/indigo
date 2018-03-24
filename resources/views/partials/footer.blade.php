<footer class="page-footer">
    <div class="container">
        <div class="row">
            <div class="col s12 l6">
                <h5 class="white-text">@lang('generic.about_blog')</h5>
                <p class="grey-text text-lighten-4">This blog is powered by <a class="white-text" href="https://github.com/MilesPong/indigo"><b>Indigo</b></a>, which is built with <a class="white-text" href="https://laravel.com/"><b>Laravel</b></a> 5 and
                    <a class="white-text" href="http://materializecss.com/"><b>Materialize</b></a> CSS.</p>
            </div>
            <div class="col s12 l4 offset-l2">
                <h5 class="white-text">@lang('generic.external_links')</h5>
                <ul>
                    <li><a href="{{ route('pages.show', 'links') }}" class="grey-text text-lighten-4">@lang('menus.links')</a></li>
                    <li><a href="{{ route('pages.show', 'about') }}" class="grey-text text-lighten-4">@lang('menus.about')</a></li>
                    <li><a href="https://github.com/MilesPong" class="grey-text text-lighten-4">Github</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            © 2018 <a class="grey-text text-lighten-4" href="https://immiles.com">Miles</a>. <span class="hide-on-small-and-down">All rights reserved.</span> <a
                        href="{{ route('feeds.main') }}" class="white-text"><i class="material-icons feed">rss_feed</i></a>
            <span class="right">
                <a class="grey-text text-lighten-4 lang-dropdown-trigger locale" href="#" data-target='lang-dropdown'><i class="material-icons">language</i>{{ $currentLocaleName }}</a> | <a class="grey-text text-lighten-4" href="https://opensource.org/licenses/MIT">MIT License</a>
            </span>
        </div>
    </div>

    @include('common.locale-dropdown', ['localeLinks' => $localeLinks])

</footer>