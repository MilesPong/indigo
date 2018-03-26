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

    <li><a href="{{ route('admin.home') }}" class="waves-effect waves-teal"><i class="material-icons">home</i>@lang('menus.home')</a></li>

    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li>
                <a class="collapsible-header waves-effect waves-teal">
                    <i class="material-icons">security</i>@lang('menus.rbac')
                </a>
                <div class="collapsible-body">
                    <ul>
                        <li>
                            <a href="{{ route('admin.permissions.index') }}" class="waves-effect">
                                <i class="material-icons"></i>@lang('menus.permissions')
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.roles.index') }}" class="waves-effect">
                                <i class="material-icons"></i>@lang('menus.roles')
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </li>

    <li><a href="{{ route('admin.users.index') }}" class="waves-effect waves-teal"><i class="material-icons">people</i>@lang('menus.users')</a></li>
    <li><a href="{{ route('admin.categories.index') }}" class="waves-effect waves-teal"><i class="material-icons">library_books</i>@lang('menus.categories')</a></li>
    <li><a href="{{ route('admin.tags.index') }}" class="waves-effect waves-teal"><i class="material-icons">loyalty</i>@lang('menus.tags')</a></li>
    <li><a href="{{ route('admin.posts.index') }}" class="waves-effect waves-teal"><i class="material-icons">insert_drive_file</i>@lang('menus.posts')</a></li>
    <li><a href="{{ route('admin.pages.index') }}" class="waves-effect waves-teal"><i class="material-icons">note</i>@lang('menus.pages')</a></li>
    <li><a href="{{ route('admin.settings.index') }}" class="waves-effect waves-teal"><i class="material-icons">settings</i>@lang('menus.settings')</a></li>
</ul>
