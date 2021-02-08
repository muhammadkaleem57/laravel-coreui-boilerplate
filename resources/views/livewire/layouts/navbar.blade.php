<header class="c-header c-header-light c-header-fixed c-header-with-subheader">
    <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
        <i class="c-icon c-icon-lg icon-menu"></i>
    </button>
    <x-jet-nav-link class="c-header-brand d-lg-none" href="/">
        <i width="118" height="46" alt="CoreUI Logo" class="icon-envelope-open"></i>
    </x-jet-nav-link>
    <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
        <i class="c-icon c-icon-lg icon-menu"></i>
    </button>

    <ul class="c-header-nav d-md-down-none">
        <li class="c-header-nav-item px-3">
            <x-jet-nav-link class="c-header-nav-link" href="{{route('dashboard')}}">
                {{__('Dashboard')}}
            </x-jet-nav-link>
        </li>
        <li class="c-header-nav-item px-3">
            <x-jet-nav-link class="c-header-nav-link" href="#">
                {{__('User')}}
            </x-jet-nav-link>
        </li>
        <li class="c-header-nav-item px-3">
            <x-jet-nav-link class="c-header-nav-link" href="#">
                {{__('Settings')}}
            </x-jet-nav-link>
        </li>
    </ul>

    <ul class="c-header-nav ml-auto mr-4">
        <li class="c-header-nav-item dropdown d-md-down-none mx-2">
            <a
                class="c-header-nav-link"
                data-toggle="dropdown"
                href="#"
                role="button"
                aria-haspopup="true"
                aria-expanded="false">
                <i class="c-icon icon-bell"></i>
                <span class="badge badge-pill badge-danger" id="new-user-notify">0</span>
            </a>
        </li>

        <li class="c-header-nav-item d-md-down-none mx-2">
            <a class="c-header-nav-link" href="#">
                <i class="c-icon icon-list"></i>
            </a>
        </li>

        <li class="c-header-nav-item d-md-down-none mx-2">
            <a class="c-header-nav-link" href="#">
                <i class="c-icon icon-envelope-open"></i>
            </a>
        </li>

        <li class="c-header-nav-item dropdown">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto admin-dropdown">
                <!-- Authentication Links -->
                @auth
                    <x-jet-dropdown id="navbarDropdown">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <img
                                    class="rounded-circle"
                                    width="32"
                                    height="32"
                                    src="{{ Auth::user()->profile_photo_url }}"
                                    alt="{{ Auth::user()->full_name }}"
                                />
                            @else
                                {{ Auth::user()->full_name }}
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <h6 class="dropdown-header small text-muted">
                                {{ __('Manage Account') }}
                            </h6>
                            <x-jet-dropdown-link href="{{route('profile.show')}}">
                                {{ __('Profile') }}
                            </x-jet-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-jet-dropdown-link>
                            @endif

                        <!-- Team Management -->
                            @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())

                                <hr class="dropdown-divider">

                                <h6 class="dropdown-header">
                                    {{ __('Manage Team') }}
                                </h6>

                                <!-- Team Settings -->
                                <x-jet-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                    {{ __('Team Settings') }}
                                </x-jet-dropdown-link>

                                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                    <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                        {{ __('Create New Team') }}
                                    </x-jet-dropdown-link>
                                @endcan

                                <hr class="dropdown-divider">

                                <!--Team Switcher-->
                                <h6 class="dropdown-header">
                                    {{ __('Switch Teams') }}
                                </h6>

                                @foreach (Auth::user()->allTeams() as $team)
                                    <x-jet-switchable-team :team="$team"/>
                                @endforeach
                            @endif

                            <hr class="dropdown-divider">

                            <!--Authentication-->
                            <x-jet-dropdown-link
                                href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </x-jet-dropdown-link>
                            <form method="POST" id="logout-form" action="{{ route('logout') }}">
                                @csrf
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                @endauth
            </ul>
        </li>
    </ul>
</header>
