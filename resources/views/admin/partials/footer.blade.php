<footer class="page-footer">
    <div class="footer-copyright">
        <div class="container">
            <span>© 2018 Miles. All rights reserved.</span>

            <span class="right">
                <a class="grey-text text-lighten-4 lang-dropdown-trigger locale" href="#" data-target='lang-dropdown'><i class="material-icons">language</i>{{ $currentLocaleName }}</a>
                <span class="hide-on-small-only"> | Powered by <a class="grey-text text-lighten-4" href="https://github.com/MilesPong/indigo">Indigo</a></span>
            </span>
        </div>
    </div>

    @include('common.locale-dropdown', ['localeLinks' => $localeLinks])

</footer>