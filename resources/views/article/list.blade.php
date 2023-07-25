@extends('layouts.app-front')
@section('title', 'Easy Réunion - Blog tous nos articles')
@section('meta-description', "Découvrez notre blog dédié aux activités du monde de l’entreprise, des professionnels ou des start-ups. Retrouvez des conseils pratiques, des idées d'événements et bien plus encore pour réussir votre prochaine réunion, formation ou séminaire.")
@section('content')
<div class="headinSet bgImg-tech">
    <h1 class="mx-auto text-[6vw] leading-none sm:text-5xl">Notre blog</h1>
</div>
    <main id="article_header" class="page">

        <h2 class="mt-10">
            Découvrez tous les articles en lien avec notre activité
        </h2>

        <section id="articles_galery" class="w-full space-y-8">
            <div class="articles_line">
                @foreach($articles as $index => $article)
                    <div class="article_item">
                        <div class="article_date">
                            {{ $article->getPublicatedAt()->format('d') }}
                            <br/>
                            <span>{{ $months[$article->getPublicatedAt()->format('n')] }}</span>
                        </div>
                        <div class="article_img">
                            <img src="{{ $arkticle->cover_img }}" alt="{{ $article->title  }}" />
                        </div>
                        <p class="article_title">{{ $article->title }}</p>
                        <a href="{{ route('articles.show', $article->slug) }}" title="{{ $article->title }}">
                            {{ $article->category->name }}:<br>
                            Continuer la lecture...
                        </a>
                    </div>

                    @if(($index + 1) % 3 === 0 && $index !== count($articles) - 1)
            </div>
            <div class="articles_line">
                @endif
                @endforeach
            </div>

            <div class="pagination">
                @for($i = 1; $i <= $pagination['totalPages']; $i++)
                    <a class="pageButton {{ $pagination['currentPage'] == $i ? 'currentPage' : '' }}" href="{{ route('articles.list', $i) }}">{{ $i }}</a>
                @endfor
            </div>
        </section>



    </main>

@endsection
