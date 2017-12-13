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

    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li>
                <a class="collapsible-header waves-effect waves-teal">
                    <i class="material-icons">security</i>RBAC
                </a>
                <div class="collapsible-body">
                    <ul>
                        <li>
                            <a href="{{ route('admin.permissions.index') }}" class="waves-effect">
                                <i class="material-icons"></i>Permissions
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.roles.index') }}" class="waves-effect">
                                <i class="material-icons"></i>Roles
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </li>

    <li><a href="{{ route('admin.users.index') }}" class="waves-effect waves-teal"><i class="material-icons">people</i>Users</a></li>
    <li><a href="{{ route('admin.categories.index') }}" class="waves-effect waves-teal"><i class="material-icons">library_books</i>Categories</a></li>
    <li><a href="{{ route('admin.tags.index') }}" class="waves-effect waves-teal"><i class="material-icons">loyalty</i>Tags</a></li>
    <li><a href="{{ route('admin.posts.index') }}" class="waves-effect waves-teal"><i class="material-icons">insert_drive_file</i>Posts</a></li>
    <li><a href="{{ route('admin.settings.index') }}" class="waves-effect waves-teal"><i class="material-icons">settings</i>Settings</a></li>
</ul>
