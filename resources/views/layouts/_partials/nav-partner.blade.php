<a href="{{ route('partner.dashboard') }}"
   class="{{ Route::is('partner.dashboard') ? 'bg-gray-900 text-white' : 'text-gray-300' }} hover:bg-gray-700  group flex items-center px-2 nav-el py-2 {{ $mobile ? 'text-base' : 'text-sm' }} font-medium rounded-md">

    <svg class="text-gray-300 group-hover:text-gray-300  h-6 w-6"
         xmlns="http://www.w3.org/2000/svg" fill="none"
         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
    </svg>
    <span class="nav-text ml-{{ $mobile ? '4' : '3' }}">Accueil</span>
</a>

<a href="{{ route('partner.bookings.index') }}"
   class="{{ Route::is('partner.bookings.*') ? 'bg-gray-900 text-white' : 'text-gray-300' }} hover:bg-gray-700 hover:text-white group flex items-center px-2 nav-el py-2 {{ $mobile ? 'text-base' : 'text-sm' }} font-medium rounded-md">


    <svg xmlns="http://www.w3.org/2000/svg"
         class="text-gray-300 group-hover:text-gray-300  h-6 w-6"
         fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/>
    </svg>
    <span class="nav-text ml-{{ $mobile ? '4' : '3' }}">Réservations</span>
</a>

@if($selectedPartner->type === 'spaceowner')
    <a href="{{ route('partner.space-groups.index') }}"
       class="{{ Route::is('partner.space-groups.*') ||  Route::is('partner.spaces.*')? 'bg-gray-900 text-white' : 'text-gray-300' }} hover:bg-gray-700 hover:text-white group flex items-center px-2 nav-el py-2 text-{{ $mobile ? 'base' : 'sm' }} font-medium rounded-md">

        <svg xmlns="http://www.w3.org/2000/svg"
             class="text-gray-300 group-hover:text-gray-300 h-6 w-6"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
        </svg>
        <span class="nav-text ml-{{ $mobile ? '4' : '3' }}">Espaces</span>

    </a>

@endif

<a href="{{ route('calendar') }}"
   class="{{ Route::is('calendar') ? 'bg-gray-900 text-white' : 'text-gray-300' }} hover:bg-gray-700 hover:text-white group flex items-center px-2 nav-el py-2 text-{{ $mobile ? 'base' : 'sm' }} font-medium rounded-md">

    <svg xmlns="http://www.w3.org/2000/svg"
         class="text-gray-300 group-hover:text-gray-300 h-6 w-6"
         fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
    </svg>
    <span class="nav-text ml-{{ $mobile ? '4' : '3' }}">Agendas</span>
</a>



<a href="{{ route('partner.team.index') }}"
   class="{{ Route::is('partner.team.*') ? 'bg-gray-900 text-white' : 'text-gray-300' }} hover:bg-gray-700 hover:text-white group flex items-center px-2 nav-el py-2 text-{{ $mobile ? 'base' : 'sm' }} font-medium rounded-md">


    <svg xmlns="http://www.w3.org/2000/svg"
         class="text-gray-300 group-hover:text-gray-300  h-6 w-6" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
    </svg>
    <span class="nav-text ml-{{ $mobile ? '4' : '3' }}">Équipe</span>
</a>

<a href="{{ route('partner.settings.get') }}"
   class="{{ Route::is('partner.settings.get') ? 'bg-gray-900 text-white' : 'text-gray-300' }} hover:bg-gray-700 hover:text-white group flex items-center px-2 nav-el py-2 text-{{ $mobile ? 'base' : 'sm' }} font-medium rounded-md">

    <svg xmlns="http://www.w3.org/2000/svg"
         class="text-gray-300 group-hover:text-gray-300  h-6 w-6" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
    </svg>
    <span class="nav-text ml-{{ $mobile ? '4' : '3' }}">Paramètres</span>
</a>

