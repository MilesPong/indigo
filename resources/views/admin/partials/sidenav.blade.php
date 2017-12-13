{{-- SideNav --}}
<ul id="slide-out" class="sidenav sidenav-fixed">
    <li>
        <div class="user-view">
            <div class="background teal">
            </div>
            <a href="#!user"><img class="circle" src="{{ asset('images/avatar.jpg') }}"></a>
            <a href="#!name"><span class="white-text name">{{ Auth::user()->name }}</span></a>
            <a href="#!email"><span class="white-text email">{{ Auth::user()->email }}</span></a>
        </div>
    </li>

    <li><a href="{{ route('admin.home') }}" class="waves-effect waves-teal"><i class="material-icons">home</i>Home</a></li>

    <li class="no-padding {{ setActiveClass('stores') }}">
        <ul class="collapsible collapsible-accordion">
            <li>
                <a class="collapsible-header waves-effect waves-teal">
                    <i class="material-icons">edit</i>Post
                </a>
                <div class="collapsible-body">
                    <ul>
                        <li class="{{ setActiveClass('stores') }}">
                            <a href="#" class="waves-effect">
                                <i class="material-icons"></i>Index
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </li>
</ul>
