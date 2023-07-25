@extends('layouts.app-front')

@section('title', __('meta.auth.password_forgotten.title'))
@section('meta-description', __('meta.auth.password_forgotten.description'))

@section('content')
    <div style="background-image:url({{ asset('/images/er-image-bg.jpg') }})"
         class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8  bg-no-repeat bg-cover">

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 mb-6">
                    {{ __('auth.recover_password') }}
                </h2>

                @if(session('success'))
                    {{ session('success') }}
                @else

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('auth.request-password') }}" class="space-y-6">
                        @csrf
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                {{ __('auth.email') }}
                            </label>
                            <div class="mt-1">
                                <input id="email"
                                       placeholder="chuck.bartowski@liigem.io"
                                       name="email" type="email" autocomplete="email" required
                                       class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>
                        <input
                            class="w-full text-xs btn dark h-in"
                            type="submit" value="{{ __('auth.recover_password') }}">
                    </form>

                @endif
            </div>
        </div>
    </div>
@endsection
