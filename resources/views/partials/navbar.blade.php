<nav>
    <div class="nav-wrapper container">
        <a href="/" class="brand-logo">Indigo</a>
        <a href="#" data-activates="mobile-nav" class="button-collapse"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
            <li><a href="#!">Resume</a></li>
            <li><a href="#!">Contact</a></li>
            <li><a href="#!">Github</a></li>
        </ul>
        <ul class="side-nav" id="mobile-nav">
            <li><a href="#!">Resume</a></li>
            <li><a href="#!">Contact</a></li>
            <li><a href="#!">Github</a></li>
        </ul>
    </div>
</nav>

@push('js')
<script>
    $(function(){
        $(".button-collapse").sideNav();
    })
</script>
@endpush