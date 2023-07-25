@extends('layouts.email')

@section('content')
    Bonjour ! <br/>

    Merci de signer le devis à l'URL suivante : {{ $url }}
@endsection
