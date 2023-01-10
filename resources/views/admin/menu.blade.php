<ul class="navbar-nav ms-auto">
    <li class="nav-item">
        <a href="{{ route('admin/dashboard') }}" class="nav-link @if ($current_nav_tab == "dashboard") nav-link-active @endif"> Dashboard </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin/articles') }}" class="nav-link @if ($current_nav_tab == "articles") nav-link-active @endif"> Articles </a>
    </li>
    <li class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle @if ($current_nav_tab == "users") nav-link-active @endif" role="button" data-bs-toggle="dropdown"> Users </a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('admin/manage-admins') }}"> Administrators </a></li>
            <li><a class="dropdown-item" href="{{ route('admin/manage-journalists') }}"> Journalists </a></li>
            <li><a class="dropdown-item" href="{{ route('admin/manage-users') }}"> Users </a></li>
        </ul>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin/dashboard') }}" class="nav-link @if ($current_nav_tab == "settings") nav-link-active @endif"> Settings </a>
    </li>
    <li class="nav-item nav-item-empty"></li>
    @guest
        @if (Route::has('login'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Sign In') }}</a>
            </li>
        @endif

        @if (Route::has('register'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Sign Up') }}</a>
            </li>
        @endif
    @else
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }}
            </a>

            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    @endguest
</ul>
