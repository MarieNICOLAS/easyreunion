<a href="{{ route('user.bookings.index') }}"
   class="{{ Route::is('user.bookings') ? 'bg-gray-900 text-white' : 'text-gray-300' }} hover:bg-gray-700  group flex items-center px-2 nav-el py-2 {{ $mobile ? 'text-base' : 'text-sm' }} font-medium rounded-md">

    <svg class="text-gray-300 group-hover:text-gray-300  h-6 w-6"
         xmlns="http://www.w3.org/2000/svg" fill="none"
         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
    </svg>
    <span class="nav-text ml-{{ $mobile ? '4' : '3' }}"> Mes commandes</span>

</a>
<a href="{{ route('messaging.index') }}"
   class="{{ Route::is('messaging.*') ? 'bg-gray-900 text-white' : 'text-gray-300' }} hover:bg-gray-700 hover:text-white group flex items-center px-2 nav-el py-2 {{ $mobile ? 'text-base' : 'text-sm' }} font-medium rounded-md">

    <svg xmlns="http://www.w3.org/2000/svg"
         class="text-gray-300 group-hover:text-gray-300  h-6 w-6" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
    </svg>
    <span class="nav-text ml-{{ $mobile ? '4' : '3' }}"> Messagerie</span>
</a>
