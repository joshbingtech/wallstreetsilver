<div class="header">
    <nav class="navbar navbar-expand-md navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img id="logo" src="{{ asset('images/logo.png') }}" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbar">
                @guest
                    @include('user.menu')
                @else
                    @if (Auth::user()->role == 0)
                        @include('admin.menu')
                    @elseif (Auth::user()->role == 2)
                        @include('user.menu')
                    @endif
                @endguest
            </div>
        </div>
    </nav>
</div>
