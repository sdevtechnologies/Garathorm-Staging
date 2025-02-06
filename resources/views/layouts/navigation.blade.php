<nav class="navbar navbar-expand px-3 py-4 border-bottom shadow">
    <button class="sidebar-toggle" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse navbar">
        <!--
        <div class="m-auto">
            <img src="{{URL::to('images/inception_logo.png')}}" class="homepage_logo" />
        </div>
    -->
        <!--
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a href="#" data-bs-toggle="dropdown" class="nav-icon" pe-md-0>
                    <img src="{{URL::to('images/user.png')}}" class="avatar img-fluid rounded" alt=""/>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="{{route('profile.edit')}}" class="dropdown-item">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                    <a href="{{route('profile.edit')}}"  onclick="event.preventDefault();
                    this.closest('form').submit();" class="dropdown-item">Log Out</a>
                    </form>
                </div>
            </li>
        </ul>
    -->
    </div>
</nav>