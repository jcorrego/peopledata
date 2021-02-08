<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/images/icons/cropped-500pxElEncuentro-32x32.jpg" sizes="32x32">
    <link rel="icon" href="/images/icons/cropped-500pxElEncuentro-192x192.jpg" sizes="192x192">
    <link rel="apple-touch-icon-precomposed" href="/images/icons/cropped-500pxElEncuentro-180x180.jpg">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'El Encuentro Con Dios') }}</title>
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ asset('js/dropzone.js') }}"></script>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dropzone.css') }}" rel="stylesheet">
    <script defer src="{{ asset('js/fontawesome-all.js') }}"></script>
</head>
<body>
    <div id="app">
        @php
            $url = \Illuminate\Support\Facades\Request::url();
            $menu = [
            [
                'link'=> '/courses',
                'label'=> 'Cursos',
                'active'=> url('/courses') == $url
            ],
            [
                'link'=> '/courses/create',
                'label'=> 'Agregar Curso',
                'active'=> url('/courses/create') == $url
            ],
            [
                'link'=> '/members/unfinished/2021-1',
                'label'=> 'Deserciones',
                'active'=> url('/members/unfinished/2021-1') == $url
            ]
        ];
        @endphp
        <div>
            <div class="bg-gray-800 pb-32">
                <nav class="bg-gray-800">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="border-b border-gray-700">
                            <div class="flex items-center justify-between h-16 px-4 sm:px-0">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <img class="h-8" src="{{ asset('images/logos/el-encuentro-168x100.png') }}" alt="El Encuentro con Dios" />
                                    </div>
                                    <div class="hidden md:block">
                                        <div class="ml-10 flex items-baseline">
                                            @foreach($menu as $item)
                                                @if( $item['active'] )
                                                    <a href="{{ $item['link'] }}" class="ml-4 px-3 py-2 rounded-md text-sm font-medium text-white bg-gray-900 focus:outline-none focus:text-white focus:bg-gray-700">{{ $item['label'] }}</a>
                                                @else
                                                    <a href="{{ $item['link'] }}" class="ml-4 px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">{{ $item['label'] }}</a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-1 flex justify-center px-2 md:ml-6 md:justify-end">
                                    <div class="max-w-lg w-full lg:max-w-xs">
                                        <form action="/members/search" method="post">
                                            {{ csrf_field() }}
                                            <label for="search" class="sr-only">Buscar estudiante</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <input name="search" id="search" class="block w-full pl-10 pr-3 py-2 border border-transparent rounded-md leading-5 bg-gray-700 text-gray-300 placeholder-gray-400 focus:outline-none focus:bg-white focus:text-gray-900 sm:text-sm transition duration-150 ease-in-out" placeholder="Buscar estudiante" type="search">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="hidden md:block">
                                    <div class="ml-4 flex items-center md:ml-6">
                                        <button class="p-1 border-2 border-transparent text-gray-400 rounded-full hover:text-white focus:outline-none focus:text-white focus:bg-gray-700" aria-label="Notifications">
                                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                            </svg>
                                        </button>
                                        <div class="ml-3 relative" >
                                            <div>
                                                <button @blur="profileDropdown = false" @click="profileDropdown = !profileDropdown" class="max-w-xs flex items-center text-sm rounded-full text-white focus:outline-none focus:shadow-solid" id="user-menu" aria-label="User menu" aria-haspopup="true">
                                                    <img class="h-8 w-8 rounded-full" src="{{ auth()->user()->member->image }}" alt="{{ auth()->user()->name }}" />
                                                </button>
                                            </div>
                                            <transition
                                                    enter-active-class="transition ease-out duration-100"
                                                    enter-class="transform opacity-0 scale-95"
                                                    enter-to-class="transform opacity-100 scale-100"
                                                    leave-active-class="transition ease-in duration-75"
                                                    leave-class="transform opacity-100 scale-100"
                                                    leave-to-class="transform opacity-0 scale-95"
                                            >
                                            <div v-show="profileDropdown" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg">
                                                <div class="py-1 rounded-md bg-white shadow-xs">
                                                    <a href="/members/{{ auth()->user()->member_id }}/edit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Editar Mi Perfil</a>
                                                    <a href="/members/{{ auth()->user()->member_id }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ver Mi Perfil</a>
                                                    <a href="{{ route('logout') }}"
                                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Salir') }}</a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
                                                </div>
                                            </div>
                                            </transition>
                                        </div>
                                    </div>
                                </div>
                                <div class="-mr-2 flex md:hidden">
                                    <button @click="mobileMenu = !mobileMenu" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white">
                                        <svg :class="mobileMenu ? 'hidden' : 'block'" class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                        </svg>
                                        <svg :class="mobileMenu ? 'block' : 'hidden'" class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div :class="mobileMenu ? 'block':'hidden'" class="border-b border-gray-700 md:hidden">
                        <div class="px-2 py-3 sm:px-3">
                            @foreach($menu as $item)
                                @if( $item['active'] )
                                    <a href="{{ $item['link'] }}" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-gray-900 focus:outline-none focus:text-white focus:bg-gray-700">{{ $item['label'] }}</a>
                                @else
                                    <a href="{{ $item['link'] }}" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">{{ $item['label'] }}</a>
                                @endif
                            @endforeach
                        </div>
                        <div class="pt-4 pb-3 border-t border-gray-700">
                            <div class="flex items-center px-5">
                                <div class="flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full" src="{{ auth()->user()->member->image }}" alt="{{ auth()->user()->name }}" />
                                </div>
                                <div class="ml-3">
                                    <div class="text-base font-medium leading-none text-white">{{ auth()->user()->name }}</div>
                                    <div class="mt-1 text-sm font-medium leading-none text-gray-400">{{ auth()->user()->email }}</div>
                                </div>
                            </div>
                            <div class="mt-3 px-2" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
                                <a href="/members/{{ auth()->user()->member_id }}/edit" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700" role="menuitem">Editar Mi Perfil</a>
                                <a href="/members/{{ auth()->user()->member_id }}" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700" role="menuitem">Ver Mi Perfil</a>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form-mobile').submit();"
                                   class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700" role="menuitem">{{ __('Salir') }}</a>
                                <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </nav>
                <header class="py-10">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        @yield('title')
                    </div>
                </header>
            </div>
            <main class="-mt-32">
                <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8">
                    <div class="bg-white rounded-lg shadow px-5 py-6 sm:px-6">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>
    @yield('scripts')
</body>
</html>
