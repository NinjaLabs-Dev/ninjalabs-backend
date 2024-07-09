<div class="d-flex flex-column flex-shrink-0 p-3 bg-light vh-100 nav shadow-sm">
    <a href="/" class="d-flex align-items-center link-dark text-decoration-none my-3 header">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 171.89 146.91" class="mr-2"><defs><style>.cls-1{fill:#212121;}</style></defs><title>Logo</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><polygon class="cls-1" points="171.89 16.36 126.38 123.31 116.34 146.91 111.7 146.82 94.88 129.62 55.81 89.65 67.41 61.95 106.22 102.33 141.86 16.55 171.89 16.36"/><polygon class="cls-1" points="65.67 44.58 30.03 130.36 0 130.55 45.51 23.6 55.55 0 60.19 0.09 77.01 17.29 116.08 57.26 104.48 84.96 65.67 44.58"/></g></g></svg>
        <span class="mb-0">NinjaLabs</span>
    </a>
    <hr class="mb-2">
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" @if(\Route::current()->getName() === 'dashboard') class="nav-link active" aria-current="page" @else class="nav-link link-dark" @endif>
                <i class='bx bx-home'></i>
                Home
            </a>
            <a href="{{ route('custom.urls') }}" @if(\Route::current()->getName() === 'custom.urls') class="nav-link active" aria-current="page" @else class="nav-link link-dark" @endif>
                <i class='bx bx-link-alt'></i>
                Custom URLs
            </a>
            @can('mysql backups')
                <a href="{{ route('backups') }}" @if(\Route::current()->getName() === 'backups') class="nav-link active" aria-current="page" @else class="nav-link link-dark" @endif>
                    <i class='bx bx-data'></i>
                    Backups
                </a>
            @endcan
        </li>
    </ul>
    <hr>
    <div class="dropdown my-2">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-current="false">
            <strong class="pl-2 mr-2">{{ Auth::user()->name }}</strong>
        </a>

        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser" style="">
            <li><a class="dropdown-item" href="{{ route('user.settings') }}">Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route('logout') }}">Log out</a></li>
        </ul>
    </div>
</div>
