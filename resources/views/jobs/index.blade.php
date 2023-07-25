@extends('layouts.app-front')

@section('title', __('meta.jobs.title'))
@section('description', __('meta.jobs.description'))

@section('content')
    <div class="relative text-white py-36 background-banniere">
    </div>
    <div class="space-x-12  md:px-28">
        <h1 class="text-center text-black text-3xl font-bold my-10">Offres d'emploi</h1>
        <h2>
            Easy Réunion recrute
        </h2>
        <p class="my-2 mt-5">
            Nous sommes constamment à la recherche de personnes talentueuses et motivées pour rejoindre notre équipe.
            Nous sommes convaincus que notre succès dépend avant tout de notre équipe, raison pour laquelle nous
            attachons une grande importance à la formation de nos collaborateurs, afin de leur permettre de développer
            des compétences solides.
            </br>
            Vous souhaitez rejoindre notre équipe ? </br> Consultez nos offres d’emploi ci-dessous et n’hésitez pas à
            nous soumettre votre candidature ! </br> Nous sommes impatients de découvrir les talents qui se cachent
            parmi vous.
        </p>
        @foreach(\App\Models\Front\JobOffer::active()->get() as $job)
            <div class="my-10">
                <details {{ $loop->first ? 'open' : '' }}>
                    <summary class="text-2xl font-bold cursor-pointer">{{ $job->title }}</summary>
                    <p>{!! $job->description !!}</p>
                </details>

            </div>
        @endforeach
    </div>
@endsection
