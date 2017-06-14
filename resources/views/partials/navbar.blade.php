<div class="navbar-fixed">
    <nav id="nav-bar" class="z-depth-0">
        <div class="nav-wrapper container">
            <a href="/" class="brand-logo">Indigo</a>
            <a href="#" data-activates="mobile-nav" class="button-collapse"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <li><a class="waves-effect waves-light" href="#!">Resume</a></li>
                <li><a class="waves-effect waves-light" href="#!">Contact</a></li>
                <li><a class="waves-effect waves-light" href="#!">Github</a></li>
            </ul>
        </div>
    </nav>
</div>
<ul class="side-nav" id="mobile-nav">
    <li><a class="waves-effect waves-light waves-teal" href="#!">Resume</a></li>
    <li><a class="waves-effect waves-light waves-teal" href="#!">Contact</a></li>
    <li><a class="waves-effect waves-light waves-teal" href="#!">Github</a></li>
</ul>

@push('js')
<script>
    $(function(){
        $(".button-collapse").sideNav();

        $(window).scroll(function() {
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