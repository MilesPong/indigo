{{-- SideNav --}}
<ul id="slide-out" class="sidenav">

    <li>
        <div class="user-view">
            <div class="background">
                <img src="{{ asset('images/office.jpg') }}" alt="">
            </div>
            <a href="#!user"><img class="circle" src="{{ asset('images/avatar.jpg') }}"></a>
            <a href="#!name"><span class="white-text name">Miles Peng</span></a>
            <a href="mailto:mingpeng16@gmail.com"><span class="white-text email">mingpeng16@gmail.com</span></a>
        </div>
    </li>

    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">

            <li>
                <a class="collapsible-header waves-effect waves-teal">
                    <i class="material-icons">apps</i>Category
                </a>
                <div class="collapsible-body">
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
