<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <title>@yield('title', 'Easy Réunion')</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}"/>
    <link rel="stylesheet" href="{{ mix('css/backoffice.css') }}"/>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/logo/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/logo/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('images/logo/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    @if(\Illuminate\Support\Facades\Auth::user()->rank === 'admin')

        <input type="hidden" id="baseURL" value="{{ \Illuminate\Support\Facades\URL::to('/') }}/admin/search"/>
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('head')
</head>
<body>
<div id="app">
    <div class="h-screen flex overflow-hidden bg-gray-100">
        <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
        <transition duration="300">
            <div class="md:hidden" v-show="isMobileMenuOpen">
                <div class="fixed inset-0 flex z-40">
                    <transition
                        enter-active-class="transition-opacity ease-linear duration-300"
                        enter-from-class="opacity-0"
                        enter-to-class="opacity-100"
                        leave-active-class="transition-opacity ease-linear duration-300"
                        leave-from-class="opacity-100"
                        leave-to-class="opacity-0">
                        <div class="fixed inset-0" aria-hidden="true" v-show="isMobileMenuOpen">
                            <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
                        </div>
                    </transition>

                    <transition
                        enter-active-class="transition ease-in-out duration-300 transform"
                        enter-from-class="-translate-x-full"
                        enter-to-class="translate-x-0"
                        leave-active-class="transition ease-in-out duration-300 transform"
                        leave-from-class="translate-x-0"
                        leave-to-class="-translate-x-full">
                        <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-gray-800"
                             v-show="isMobileMenuOpen">
                            <div class="absolute top-0 right-0 -mr-12 pt-2">
                                <button @click="isMobileMenuOpen=false"
                                        class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                                    <span class="sr-only">Fermer sidebar</span>
                                    <!-- Heroicon name: outline/x -->
                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex-shrink-0 flex items-center px-4">
                                <h3 class="h-8 w-auto text-white">Easy Réunion</h3>
                            </div>
                            <div class="mt-5 flex-1 h-0 overflow-y-auto">
                                <nav class="px-2 space-y-1">
                                    @if(Auth::user()->is_admin)
                                        @include('layouts._partials.nav-admin', ['mobile' => true])
                                    @elseif(Auth::user()->is_partner)
                                        @include('layouts._partials.nav-partner', ['mobile' => true])
                                    @else
                                        @include('layouts._partials.nav-user', ['mobile' => true])
                                    @endif
                                </nav>
                            </div>
                        </div>
                    </transition>
                    <div class="flex-shrink-0 w-14" aria-hidden="true">
                        <!-- Dummy element to force sidebar to shrink to fit close icon -->
                    </div>
                </div>
            </div>
        </transition>
        <!-- Static sidebar for desktop -->
        <div
            :class="collapsedSidebar ? 'hidden md:flex md:flex-shrink-0 collapsedSidebar' : 'hidden md:flex md:flex-shrink-0'"
            id="navbar-left">
            <div class="flex flex-col">
                <!-- Sidebar component, swap this element with another sidebar if you like -->
                <div class="flex flex-col h-0 flex-1">
                    <div class="flex items-center h-16 flex-shrink-0 bg-gray-100 justify-center">
                        <a href="{{ Auth::user()->homeUrl }}">
                            <img v-show="!collapsedSidebar"
                                 class="h-8 w-auto mx-6"
                                 src="{{ asset('images/logo/new-logo-xs.png') }}"
                                alt="Easy Réunion"/>
                            <img  v-show="collapsedSidebar"
                                  class="h-8 w-auto"
                                  src="{{ asset('images/logo/apple-touch-icon.png') }}"
                                  alt="Easy Réunion"/>
                        </a>
                    </div>
                    <div  class="flex-1 flex flex-col overflow-y-auto">
                        <nav class="flex-1 px-2 py-4 bg-gray-800 space-y-1">
                            @if(Auth::user()->is_admin)
                                @include('layouts._partials.nav-admin', ['mobile' => false])
                            @elseif(Auth::user()->is_partner)
                                @include('layouts._partials.nav-partner', ['mobile' => false])
                            @else
                                @include('layouts._partials.nav-user', ['mobile' => false])
                            @endif
                                <a href="#" @click="toggleSidebar"
                                   class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center py-2 px-2 nav-el text-sm font-medium rounded-md">

                                    <svg v-show="!collapsedSidebar" xmlns="http://www.w3.org/2000/svg"
                                         class="text-gray-300 group-hover:text-gray-300 h-6 w-6" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                                    </svg>

                                    <svg v-show="collapsedSidebar" xmlns="http://www.w3.org/2000/svg"
                                         class="text-gray-300 group-hover:text-gray-300 h-6 w-6" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                                    </svg>

                                    <span v-show="!collapsedSidebar" class="nav-text ml-3">Rétrécir</span>
                                    <span v-show="collapsedSidebar" class="nav-text ml-3">Agrandir</span>
                                </a>
                        </nav>
                        <a href="{{ route('welcome') }}" class="bg-blue-dark text-white w-full text-center pb-8">&larr;
                            <span class="nav-text">Retour au site</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow">
                <button
                    @click="isMobileMenuOpen=true"
                    class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden ">
                    <span class="sr-only">Ouvrir sidebar</span>
                    <!-- Heroicon name: outline/menu-alt-2 -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                </button>
                <div class="flex-1 px-4 flex justify-between">
                    <div class="flex-1 flex">
                        @if(Auth::user()->is_admin)
                            <form class="w-full flex md:ml-0" action="#" method="GET">
                                <label for="search_field" class="sr-only">Recherche</label>
                                <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                                    <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                                        <!-- Heroicon name: solid/search -->
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                             fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                  d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <input id="search"
                                           class="block w-full h-full pl-8 pr-3 py-2 border-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-0 focus:border-transparent sm:text-sm"
                                           placeholder="Recherche" type="search" name="search">
                                </div>
                            </form>
                        @endif
                    </div>
                    <div class="ml-4 flex items-center md:ml-6">
                        <button
                            @click="this.toggleNotifications();"
                            type="button"
                            class="bg-white p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span class="sr-only">Voir notifications</span>
                            <svg class="h-6 w-6" x-description="Heroicon name: outline/bell"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            @if(Auth::user()->unreadNotifications()->count() > 0)
                                <span class="absolute -mt-2">
                                     <div
                                         class="inline-flex items-center px-1.5 py-0.5 border-2 border-white rounded-full text-xs font-semibold leading-4 bg-red-500 text-white">
                                         {{ Auth::user()->unreadNotifications()->count() }}
                                     </div>
                                </span>
                            @endif
                        </button>
                        <transition
                            enter-active-class="transition ease-out duration-100 transform"
                            enter-from-class="opacity-0 scale-95"
                            enter-to-class="opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75 transform"
                            leave-from-class="opacity-100 scale-100"
                            leave-to-class="opacity-0 scale-95"
                        >

                            <div v-show="isNotificationsOpen"
                                 class="origin-top-right absolute right-10 mt-24 w-96 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 p-4"
                                 role="menu" aria-orientation="vertical">
                                <table>
                                    <tbody>

                                    @forelse(Auth::user()->unreadNotifications()->paginate(4) as $notification)

                                        <tr onclick="window.location='{{ $notification->data['link'] }}'"
                                            class="cursor-pointer">
                                            <td>{!! $notification->data['icon']  !!}</td>
                                            <td>    {{ $notification->data['message'] }} <br/> <span
                                                    class="text-xs">{{ $notification->created_at }}</span></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>Aucune nouvelle notification</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </transition>

                        <!-- Profile dropdown -->
                        <div class="ml-3 relative">
                            <div>
                                <button @click="isUserProfileOpen = !isUserProfileOpen"
                                        class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        id="user-menu" aria-haspopup="true">
                                    <span class="sr-only">Ouvrir menu utilisateur</span>
                                    <img class="h-8 w-8 rounded-full"
                                         src="{{ asset('storage/users/'. Auth::user()->avatar) }}"
                                         alt="">
                                </button>
                            </div>


                            <transition
                                enter-active-class="transition ease-out duration-100 transform"
                                enter-from-class="opacity-0 scale-95"
                                enter-to-class="opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75 transform"
                                leave-from-class="opacity-100 scale-100"
                                leave-to-class="opacity-0 scale-95"
                            >

                                <div v-show="isUserProfileOpen"
                                     class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg
                                     py-1 bg-white ring-1 ring-black ring-opacity-5 mx-2 text-center "
                                     role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
                                    <span>{{ Auth::user()->name }}</span>
                                    <hr/>
                                    <div class="text-left">
                                        <a href="{{ route('user.settings.index') }}"
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                           role="menuitem">Paramètres</a>

                                        <a href="{{ route('auth.logout') }}"
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                           role="menuitem">Déconnexion</a>
                                    </div>
                                </div>
                            </transition>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-1 relative overflow-y-auto focus:outline-none" tabindex="0">
                <div class="py-6 px-4 2xl:px-8">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ mix('js/admin.js') }}"></script>
@stack('end-body')
</body>
</html>
