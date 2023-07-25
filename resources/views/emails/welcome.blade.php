@extends('layouts.email')

@section('content')
    <div style="Margin-left: 20px;Margin-right: 20px;">
        <div style="mso-line-height-rule: exactly;mso-text-raise: 11px;vertical-align: middle;">
            <h1 style="Margin-top: 0;Margin-bottom: 20px;font-style: normal;font-weight: normal;color: #3d3b3d;font-size: 30px;line-height: 38px;text-align: left;">
                {{ __('auth.email_welcome_subject') }}</h1>
        </div>
    </div>


    <div style="Margin-left: 20px;Margin-right: 20px;">
        <div style="mso-line-height-rule: exactly;mso-text-raise: 11px;vertical-align: middle;">
            <h3 style="Margin-top: 0;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #3d3b3d;font-size: 17px;line-height: 26px;">
                {{ __('auth.email_welcome_headline_1') }}</h3>
            <h3 style="Margin-top: 12px;Margin-bottom: 12px;font-style: normal;font-weight: normal;color: #3d3b3d;font-size: 17px;line-height: 26px;">
                {{ __('auth.email_welcome_headline_2') }}</h3>
        </div>
    </div>


    <div style="Margin-left: 20px;Margin-right: 20px;">
        <div class="btn btn--flat btn--large" style="Margin-bottom: 20px;text-align: left;">
            <a
                style="border-radius: 4px;display: inline-block;font-size: 14px;font-weight: bold;line-height: 24px;padding: 12px 24px;text-align: center;text-decoration: none !important;transition: opacity 0.1s ease-in;color: #ffffff !important;background-color: #2b2e38;font-family: Times, Times New Roman, serif;"
                href="{{ route('auth.verify-email', $token) }}">{{ __('auth.email_welcome_cta') }}</a>
        </div>
    </div>
@endsection
