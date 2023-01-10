<ul class="navbar-nav me-auto">
    <li class="nav-item nav-item-empty"></li>
    <li class="nav-item">
        <a class="social-link" href="https://twitter.com" target="_blank"><img src="{{ asset('images/icons/twitter-logo.png') }}"></a>
    </li>
    <li class="nav-item">
        <a class="social-link" href="https://youtube.com" target="_blank"><img src="{{ asset('images/icons/youtube-logo.png') }}"></a>
    </li>
    <li class="nav-item">
        <a class="social-link" href="https://reddit.com" target="_blank"><img src="{{ asset('images/icons/reddit-logo.png') }}"></a>
    </li>
    <li class="nav-item">
        <a class="social-link" href="https://discord.com" target="_blank"><img src="{{ asset('images/icons/discord-logo.png') }}"></a>
    </li>
    <li class="nav-item">
        <a class="social-link" href="https://instagram.com" target="_blank"><img src="{{ asset('images/icons/instagram-logo.png') }}"></a>
    </li>
</ul>
<ul class="navbar-nav ms-auto">
    <li class="nav-item">
        <a href="#" class="nav-link"> NEWS </a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link"> CHARTS </a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link"> MERCH </a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link"> ABOUT </a>
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
