<footer class="page-footer">
    <div class="container">
        <div class="row">
            <div class="col s12 l6">
                <h5 class="white-text">About blog</h5>
                <p class="grey-text text-lighten-4">This blog is powered by <a class="white-text" href="https://github.com/MilesPong/indigo"><b>Indigo</b></a>, which is built with <a class="white-text" href="https://laravel.com/"><b>Laravel</b></a> 5 and
                    <a class="white-text" href="http://materializecss.com/"><b>Materialize</b></a> CSS.</p>
            </div>
            <div class="col s12 l4 offset-l2">
                <h5 class="white-text">External links</h5>
                <ul>
                    <li><a href="{{ route('pages.show', 'links') }}" class="grey-text text-lighten-4">Links</a></li>
                    <li><a href="{{ route('pages.show', 'about') }}" class="grey-text text-lighten-4">About</a></li>
                    <li><a href="https://github.com/MilesPong" class="grey-text text-lighten-4">Github</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            © 2018 <a class="grey-text text-lighten-4" href="https://immiles.com">Miles</a>. All rights reserved. <a
                        href="{{ route('feeds.main') }}" class="white-text"><i class="material-icons feed">rss_feed</i></a>
            <a href="https://opensource.org/licenses/MIT" class="right grey-text text-lighten-4">MIT License</a>
        </div>
    </div>
</footer>