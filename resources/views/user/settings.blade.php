@extends('layouts.app')

@section('content')
    <div class="w-full md:w-1/2 mx-auto my-auto">
        <h4>Mes paramètres</h4>
        @if ($errors->any())
            @include('_partials.alerts.errors', ['errors' => $errors->all()])
        @endif
        @if(session('success'))
            @include('_partials.alerts.success', ['success' => session('success')])
        @endif
        <form method="POST" action="{{ route('user.settings.update') }}">
            @method('PUT')
            @csrf

            <div class="form-group">
                <label for="email">
                    {{ __('auth.email') }}
                </label>
                <div class="mt-1">
                    <input id="email" name="email" type="email" autocomplete="email" required
                           value="{{ old('email') ?? Auth::user()->email }}">
                </div>
            </div>

            <div class="form-group">
                <label for="password">
                    {{ __('auth.password') }}
                </label>
                <div class="mt-1">
                    <input id="password" name="password" type="password" autocomplete="current-password"
                           placeholder="**************"/>
                </div>
            </div>

            <div class="my-2">
                <input type="checkbox"
                       name="email_notifications" {{ \Illuminate\Support\Facades\Auth::user()->email_notifications ? 'checked' : '' }} />
                <label class="ml-2">Notifications par email</label>
            </div>

            <button class="btn success h-in" type="submit">Mettre à jour</button>

        </form>
    </div>
@endsection
