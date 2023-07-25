@extends('layouts.email')

@section('content')
    <h1>{{ __('auth.email_recover_headline') }}</h1>

    <p>{{ __('auth.email_recover_content') }}</p>

    <div class="btn btn--flat btn--large" style="Margin-bottom: 20px;text-align: left;">
        <a
            style="border-radius: 4px;display: inline-block;font-size: 14px;font-weight: bold;line-height: 24px;padding: 12px 24px;text-align: center;text-decoration: none !important;transition: opacity 0.1s ease-in;color: #ffffff !important;background-color: #2b2e38;font-family: Times, Times New Roman, serif;"
            href="{{ route('auth.reset-page') . '?token=' . $token . '&email='.$email }}">{{ __('auth.email_recover_cta') }}</a>
    </div>
@endsection
