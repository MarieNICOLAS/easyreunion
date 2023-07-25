@extends('layouts.app-front')
@section('title', __('meta.request-quote.title'))
@section('meta-description', __('meta.request-quote.description'))
@section('noindex', 'noindex')
@section('canonical', config('app.url'))
@section('og-url', config('app.url'))

@section('content')
    <div class="md:w-3/4 m-auto py-2 grid gap-4 md:grid-cols-2 my-24 myMobil">
        <div class="responsive">
            <h1 class="text-2xl md:max-md:text-sm font-extrabold mb-7 fontSmobil text-black">Demande de devis
                pour {{ $space->name }}</h1>
            @include('_partials.components.slider', [
                                      'images' => $space->media->pluck('url'), 'mediaData' => $space->media
                                  ])
        </div>
        <div>
            @if ($errors->any())
                @include('_partials.alerts.errors', ['errors' => $errors->all()])
            @endif
            @if(session()->has('success'))
                @include('_partials.alerts.success', ['success' => session()->get('success')])
            @endif

            <form method="POST" action="{{ route('request-quote.post') }}" id="requestQuote" class="responsive2">
                @csrf
                <div class="grid md:grid-cols-2 gap-x-2">
                    <div class="form-group">
                        <label for="name">Nom complet</label>
                        <input maxlength="100" minlength="3" required id="name" name="name"
                               value="{{ old('name') ?? (Auth::user()?->name ) }}"
                               type="text"/>
                    </div>
                    <div class="form-group">
                        <label for="company">Entreprise</label>
                        <input maxlength="100" minlength="3" required name="company" id="company"
                               value="{{ old('company') ?? (Auth::user()?->organization?->name ) }}" type="text"/>
                    </div>
                </div>
                <div class="form-group" style="margin-top:0 !important;">
                    <label for="phone">Téléphone</label>
                    <input id="phone" name="phone" value="{{ old('company') ?? (Auth::user()?->phone ) }}" type="text"/>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input name="email" id="email" value="{{ old('email') ?? (Auth::user()?->email ) }}" type="email"/>
                </div>

                <div class="grid md:grid-cols-2 gap-x-2">
                    <div class="form-group">
                        <label for="start">Débute le</label>
                        <input id="start" name="start" value="{{ old('start') }}" type="date"/>
                    </div>
                    <div class="form-group">
                        <label for="end">Finir le</label>
                        <input name="end" id="end" value="{{ old('end') }}" type="date"/>
                    </div>
                </div>

                <div class="form-group" style="margin-top:0 !important;">
                    <label for="time">Horaires</label>
                    <select name="time">
                        <option value="day">8h30-18h</option>
                        <option value="am">8h30-12h30</option>
                        <option value="pm">13h-18h</option>
                        <option value="evening">18h30-22h30</option>
                    </select>
                </div>
                <input type="hidden" name="space" value="{{ $space['key'] }}"/>

                <div class="form-group">
                    <label>Message</label>
                    <textarea required minlength="10" maxlength="10000" name="message">{{ old('message') }}</textarea>
                </div>

                <button
                    data-sitekey="{{ config('services.recaptcha.public_key') }}"
                    data-callback='onSubmit'
                    data-action='requestQuote'
                    class="g-recaptcha btn easyBtn btnFormobil"
                >Envoyer ma demande
                </button>

            </form>
        </div>
    </div>
@endsection
@push('scripts')
    @include('_partials.components.recaptcha', ['formId' => 'requestQuote'])
@endpush
