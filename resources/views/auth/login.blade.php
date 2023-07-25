@extends('layouts.app-front')

@section('title', __('meta.auth.sign_in.title'))
@section('meta-description', __('meta.auth.sign_in.description'))

@section('content')

    <div
         class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 bgImg  bg-no-repeat bg-cover">

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="login py-8 px-4 shadow sm:rounded-lg sm:px-10 width-100">
                <h2 class="mt-6 text-center font-extrabold text-gray-900">
                    {{ __('auth.login') }}
                </h2>
                <p class="mt-2 text-center text-sm ">
                    OU
                    <a href="{{ route('auth.register-page') }}">{{ __('auth.register') }}</a>

                </p>

                @if(session('success'))
                    {{ session('success') }}
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <form action="{{ route('auth.login') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium">
                            {{ __('auth.email') }}
                        </label>
                        <div class="mt-1">
                            <input id="email"
                                   placeholder=""
                                   name="email" type="email" autocomplete="email" required
                                   value="{{ old('email') }}"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            {{ __('auth.password') }}
                        </label>
                        <div class="mt-1">
                            <input placeholder="****************" id="password" name="password" type="password"
                                   autocomplete="current-password" required
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="flex items-center justify-end">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox"
                                   class="h-4 w-4 text-blue focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="remember-me" class="ml-2 block text-sm easy-DarkBlue">
                                Se souvenir de moi
                            </label>
                        </div>
                    </div>
                    <div class="text-sm flex justify-center">
                            <a class="text-white font-extrabold forgot"
                               href="{{ route('auth.recover-password') }}">{{ __('auth.password_forgotten') }}</a>
                        </div>
                    <div class="flex justify-center">
                        <button type="submit"
                                class="btn dark h-in">
                            {{ __('auth.login') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
