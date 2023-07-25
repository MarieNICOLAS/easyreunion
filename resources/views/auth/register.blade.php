@extends('layouts.app-front')

@section('title', __('meta.auth.register.title'))
@section('meta-description', __('meta.auth.register.description'))

@section('content')

    <div style="background-image:url({{ asset('/images/er-image-bg.jpg') }})"
         class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8  bg-no-repeat bg-cover">

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    {{ __('auth.register') }}
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    OU
                    <a class="font-medium text-blue hover:text"
                       href="{{ route('auth.login-page') }}">{{ __('auth.login') }}</a>

                </p>

                @if ($errors->any())
                    @include('_partials.alerts.errors', ['errors' => $errors->all()])
                @endif

                <form action="{{ route('auth.register-page') }}" class="space-y-6" method="POST" id="register">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            {{ __('auth.email') }}
                        </label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email" required
                                   placeholder="chuck.bartowski@liigem.io" value="{{ old('email') }}"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            {{ __('auth.first_name') }}
                        </label>
                        <div class="mt-1">
                            <input id="first_name" name="first_name" type="text" required
                                   placeholder="Chuck" value="{{ old('first_name') }}"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            {{ __('auth.last_name') }}
                        </label>
                        <div class="mt-1">
                            <input id="last_name" name="last_name" type="text" required
                                   placeholder="Bartowski" value="{{ old('last_name') }}"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            {{ __('auth.password') }}
                        </label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" autocomplete="current-password"
                                   placeholder="**************"
                                   required
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            {{ __('auth.password_confirm') }}
                        </label>
                        <div class="mt-1">
                            <input id="password" name="password_confirmation" type="password" required
                                   placeholder="**************"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>


                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input required id="cgu" name="cgu" type="checkbox"
                                   class="h-4 w-4 text-blue focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="cgu" class="ml-2 block text-sm text-gray-900">
                                J'accepte les <a class="underline" target="_blank"
                                                 href="{{ route('page.show', 'cgv') }}">CGV</a>
                            </label>
                        </div>

                    </div>

                    @if(isset($_GET['redirect']))
                        <input type="hidden" name="redirect" value="{{ $_GET['redirect'] }}"/>
                    @endif

                    <div>
                        <button
                            data-sitekey="{{ config('services.recaptcha.public_key') }}"
                            data-callback='onSubmit'
                            data-action='register'
                            class="g-recaptcha w-full btn dark h-in"
                        >{{ __('auth.register') }} </button>


                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
@push('scripts')
    @include('_partials.components.recaptcha', ['formId' => 'register'])
@endpush
