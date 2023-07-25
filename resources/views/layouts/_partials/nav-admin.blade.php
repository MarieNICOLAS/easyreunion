<a href="{{ route('admin.dashboard') }}"
   class="{{ Route::is('admin.dashboard') ? 'bg-gray-900 text-white' : 'text-gray-300' }} hover:bg-gray-700  group flex items-center px-2 nav-el py-2 {{ $mobile ? 'text-base' : 'text-sm' }} font-medium rounded-md">

    <svg class="text-gray-300 group-hover:text-gray-300  h-6 w-6"
         xmlns="http://www.w3.org/2000/svg" fill="none"
         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
    </svg>
    <span class="nav-text ml-{{ $mobile ? '4' : '3' }}">Accueil</span>
</a>


<a href="{{ route('admin.estimate-requests.index') }}"
   class="{{ Route::is('admin.estimate-requests.*') ? 'bg-gray-900 text-white' : 'text-gray-300' }} hover:bg-gray-700 hover:text-white group flex items-center px-2 nav-el py-2 {{ $mobile ? 'text-base' : 'text-sm' }} font-medium rounded-md">
    <svg xmlns="http://www.w3.org/2000/svg"
         class="text-gray-300 group-hover:text-gray-300  h-6 w-6" fill="none"
         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M21 3l-6 6m0 0V4m0 5h5M5 3a2 2 0 00-2 2v1c0 8.284 6.716 15 15 15h1a2 2 0 002-2v-3.28a1 1 0 00-.684-.948l-4.493-1.498a1 1 0 00-1.21.502l-1.13 2.257a11.042 11.042 0 01-5.516-5.517l2.257-1.128a1 1 0 00.502-1.21L9.228 3.683A1 1 0 008.279 3H5z"/>
    </svg>

    <span class="nav-text ml-{{ $mobile ? '4' : '3' }}">Demandes</span>
</a>

<a href="{{ route('admin.estimates.index') }}"
   class="{{ Route::is('admin.estimates.*') ? 'bg-gray-900 text-white' : 'text-gray-300' }} hover:bg-gray-700 hover:text-white group flex items-center px-2 nav-el py-2 text-{{ $mobile ? 'base' : 'sm' }} font-medium rounded-md">

    <svg xmlns="http://www.w3.org/2000/svg"
         class="text-gray-300 group-hover:text-gray-300  h-6 w-6" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
    </svg>

    <span class="nav-text ml-{{ $mobile ? '4' : '3' }}">Devis</span>
</a>


<a href="{{ route('admin.bookings.index') }}"
   class="{{ Route::is('admin.bookings.*') ? 'bg-gray-900 text-white' : 'text-gray-300' }} hover:bg-gray-700 hover:text-white group flex items-center px-2 nav-el py-2 text-{{ $mobile ? 'base' : 'sm' }} font-medium rounded-md">

    <svg xmlns="http://www.w3.org/2000/svg"
         class="text-gray-300 group-hover:text-gray-300  h-6 w-6" fill="none"
         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
    </svg>

    <span class="nav-text ml-{{ $mobile ? '4' : '3' }}">Réservations</span>
</a>


<a href="{{ route('calendar') }}"
   class="{{ Route::is('calendar') ? 'bg-gray-900 text-white' : 'text-gray-300' }} hover:bg-gray-700 hover:text-white group flex items-center px-2 nav-el py-2 text-{{ $mobile ? 'base' : 'sm' }} font-medium rounded-md">

    <svg xmlns="http://www.w3.org/2000/svg"
         class="text-gray-300 group-hover:text-gray-300  h-6 w-6" fill="none"
         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
    </svg>

    <span class="nav-text ml-{{ $mobile ? '4' : '3' }}">Agenda</span>
</a>



<a href="{{ route('admin.sellsy-admin-login') }}"
   class="{{ Route::is('sellsy-admin-login') ? 'bg-gray-900 text-white' : 'text-gray-300' }} hover:bg-gray-700 hover:text-white group flex items-center px-2 nav-el py-2 text-{{ $mobile ? 'base' : 'sm' }} font-medium rounded-md">

    <svg style="color: white"
         class="text-gray-300 group-hover:text-gray-300 h-6 w-6"
         xmlns="http://www.w3.org/2000/svg"
         data-name="Layer 1" viewBox="0 0 24 24">
        <path d="M21,18.5H14.82A3,3,0,0,0,13,16.68V13.5h3.17A4.33,4.33,0,0,0,17.47,5,6,6,0,0,0,6.06,6.63,3.5,3.5,0,0,0,7,13.5h4v3.18A3,3,0,0,0,9.18,18.5H3a1,1,0,0,0,0,2H9.18a3,3,0,0,0,5.64,0H21a1,1,0,0,0,0-2Zm-14-7a1.5,1.5,0,0,1,0-3,1,1,0,0,0,1-1,4,4,0,0,1,7.79-1.29,1,1,0,0,0,.78.67A2.31,2.31,0,0,1,18.5,9.17a2.34,2.34,0,0,1-2.33,2.33Zm5,9a1,1,0,1,1,1-1A1,1,0,0,1,12,20.5Z" fill="white"></path></svg>
    <span class="nav-text ml-{{ $mobile ? '4' : '3' }}">Sellsy</span>
</a>



<a href="{{ route('partner.space-groups.index') }}"
   class="{{ Route::is('partner.space-groups.*') ? 'bg-gray-900 text-white' : 'text-gray-300' }} hover:bg-gray-700 hover:text-white group flex items-center px-2 nav-el py-2 text-{{ $mobile ? 'base' : 'sm' }} font-medium rounded-md">

    <svg xmlns="http://www.w3.org/2000/svg"
         class="text-gray-300 group-hover:text-gray-300 h-6 w-6"
         fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
    </svg>

    <span class="nav-text ml-{{ $mobile ? '4' : '3' }}">Espaces</span>
</a>


<a href="{{ route('admin.partners.index') }}"
   class="{{ Route::is('admin.partners.*') ? 'bg-gray-900 text-white' : 'text-gray-300' }} hover:bg-gray-700 hover:text-white group flex items-center px-2 nav-el py-2 text-{{ $mobile ? 'base' : 'sm' }} font-medium rounded-md">


    <svg xmlns="http://www.w3.org/2000/svg"
         class="text-gray-300 group-hover:text-gray-300 h-6 w-6"
         viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
    </svg>

    <span class="nav-text ml-{{ $mobile ? '4' : '3' }}">Partenaires</span>
</a>


<a href="{{ route('admin.users.index') }}"
   class="{{ Route::is('admin.users.*') ? 'bg-gray-900 text-white' : 'text-gray-300' }} hover:bg-gray-700 hover:text-white group flex items-center px-2 nav-el py-2 text-{{ $mobile ? 'base' : 'sm' }} font-medium rounded-md">
    <svg class="text-gray-300 group-hover:text-gray-300  h-6 w-6"
         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
         stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
    </svg>
    <span class="nav-text ml-{{ $mobile ? '4' : '3' }}">Utilisateurs</span>
</a>


<a href="{{ route('admin.job-offers.index') }}"
   class="{{ Route::is('admin.job-offers.*') ? 'bg-gray-900 text-white' : 'text-gray-300' }} hover:bg-gray-700 hover:text-white group flex items-center px-2 nav-el py-2 text-{{ $mobile ? 'base' : 'sm' }} font-medium rounded-md">

    <svg xmlns="http://www.w3.org/2000/svg"
         class="text-gray-300 group-hover:text-gray-300  h-6 w-6"
         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
    </svg>

    <span class="nav-text ml-{{ $mobile ? '4' : '3' }}">Offres d'emploi</span>
</a>


<a href="{{ route('admin.pages.index') }}"
   class="{{ Route::is('admin.pages.*') ? 'bg-gray-900 text-white' : 'text-gray-300' }} hover:bg-gray-700 hover:text-white group flex items-center px-2 nav-el  py-2 text-{{ $mobile ? 'base' : 'sm' }} font-medium rounded-md">


    <svg xmlns="http://www.w3.org/2000/svg"
         class="text-gray-300 group-hover:text-gray-300  h-6 w-6"
         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
    </svg>

    <span class="nav-text ml-{{ $mobile ? '4' : '3' }}"> Pages</span>
</a>

<a href="{{ route('admin.blog.index') }}"
   class="{{ Route::is('admin.blog.*') ? 'bg-gray-900 text-white' : 'text-gray-300' }} hover:bg-gray-700 hover:text-white group flex items-center px-2 nav-el  py-2 text-{{ $mobile ? 'base' : 'sm' }} font-medium rounded-md">

    <svg xmlns="http://www.w3.org/2000/svg"
         class="text-gray-300 group-hover:text-gray-300  h-7 w-7"
         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="none">
        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
    </svg>

    <span class="nav-text ml-{{ $mobile ? '4' : '3' }}"> Blog</span>
</a>

<a href="{{ route('admin.settings') }}"
   class="{{ Route::is('admin.settings') ? 'bg-gray-900 text-white' : 'text-gray-300' }} hover:bg-gray-700 hover:text-white group flex items-center px-2 nav-el py-2 text-{{ $mobile ? 'base' : 'sm' }} font-medium rounded-md">

    <svg xmlns="http://www.w3.org/2000/svg"
         class="text-gray-300 group-hover:text-gray-300 h-6 w-6" fill="none"
         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
    </svg>

    <span class="nav-text ml-{{ $mobile ? '4' : '3' }}"> Paramètres</span>
</a>
