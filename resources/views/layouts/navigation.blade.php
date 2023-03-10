<nav>
    <nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-lg-none">
        <a class="navbar-brand me-lg-5" href="{{ route('dashboard') }}">
            {{ config('app.name') }}
        </a>
        <div class="d-flex align-items-center">
            <button class="navbar-toggler d-lg-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
        <div class="sidebar-inner px-4 pt-3">
            <div class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
                <div class="d-flex align-items-center">
                    <div class="avatar-lg me-4">
                        <img src="{{ Auth::user()->avatar_full_url }}" class="card-img-top rounded-circle border-white">
                    </div>
                    <div class="d-block">
                        <h2 class="h5 mb-3">Hi, {{ Auth::user()->name }}</h2>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" class="btn btn-secondary btn-sm d-inline-flex align-items-center" onclick="event.preventDefault();this.closest('form').submit();">
                                <svg class="icon icon-xxs me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Sign Out
                            </a>
                        </form>
                    </div>
                </div>
                <div class="collapse-close d-md-none">
                    <a href="#sidebarMenu" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="true" aria-label="Toggle navigation">
                        <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <ul class="nav flex-column pt-3 pt-md-0">
                <li class="nav-item">
                    <div class="d-flex align-items-center">
                        <span class="mt-1 ms-1 sidebar-text">{{ config('app.name') }}</span>
                    </div>
                </li>
                <li class="nav-item @if(Request::routeIs('dashboard')) active @endif">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <span class="sidebar-icon">
                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                            </svg>
                        </span>
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    @php $navMasterData = Request::routeIs(['categories.*']); @endphp
                    <span class="nav-link @if(!$navMasterData) collapsed @endif d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#nav-master-data" aria-expanded="{{ $navMasterData ? 'true' : 'false' }}">
                        <span>
                            <span class="sidebar-icon">
                                <svg class="icon icon-xs me-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path fill="currentColor" d="M0 96C0 60.7 28.7 32 64 32H448c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zm64 0v64h64V96H64zm384 0H192v64H448V96zM64 224v64h64V224H64zm384 0H192v64H448V224zM64 352v64h64V352H64zm384 0H192v64H448V352z"/></svg>
                            </span>
                            <span class="sidebar-text">Master Data</span>
                        </span>
                        <span class="link-arrow">
                            <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </span>
                    <div class="multi-level collapse @if($navMasterData) show @endif" role="list" id="nav-master-data" aria-expanded="{{ $navMasterData ? 'true' : 'false' }}">
                        <ul class="flex-column nav">
                            <li class="nav-item @if(Request::routeIs('categories.index')) active @endif">
                                <a class="nav-link" href="{{ route('categories.index') }}">
                                    Category
                                </a>
                            </li>
                        </ul>
                        <ul class="flex-column nav">
                            <li class="nav-item @if(Request::routeIs('departments.index')) active @endif">
                                <a class="nav-link" href="{{ route('departments.index') }}">
                                    Department
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    @php $navUser = Request::routeIs(['users.*']); @endphp
                    <span class="nav-link @if(!$navUser) collapsed @endif d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#nav-user" aria-expanded="{{ $navUser ? 'true' : 'false' }}">
                        <span>
                            <span class="sidebar-icon">
                                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M288 320a224 224 0 1 0 448 0 224 224 0 1 0-448 0zm544 608H160a32 32 0 0 1-32-32v-96a160 160 0 0 1 160-160h448a160 160 0 0 1 160 160v96a32 32 0 0 1-32 32z"/></svg>
                            </span>
                            <span class="sidebar-text">Master User</span>
                        </span>
                        <span class="link-arrow">
                            <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </span>
                    <div class="multi-level collapse @if($navUser) show @endif" role="list" id="nav-user" aria-expanded="{{ $navUser ? 'true' : 'false' }}">
                        <ul class="flex-column nav">
                            <li class="nav-item @if(Request::routeIs('users.index')) active @endif">
                                <a class="nav-link" href="{{ route('users.index') }}">
                                    User
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- <li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li> --}}
            </ul>
        </div>
    </nav>
</nav>