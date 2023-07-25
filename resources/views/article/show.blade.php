@extends('layouts.app-front')
@section('title', $article->title)
@section('meta-description', substr($article->resume, 0,200))
@section('canonical', Request::url() )
@section('meta_tags', '<meta property="og:image" content="{{ URL::asset($article->cover_img) }}">')



@section('content')

    <div id="showArticle">

        <img id="cover_img" src="{{ URL::asset($article->cover_img) }}" alt="{{ $article->title }}"/>


        <div id="header-div" class="w-full space-y-12 max-w-screen-xl mx-auto pt-6 pb-16 px-24">
            <header>
                <div class="breadcrumbs breadcrumbsBlog">
                    <div>
                        <div class="breadcrumbsItem ">
                            <a href="{{ route('welcome') }}" title="Accueil Easy Reunion">
                                <i class="material-icons">home</i>
                            </a>
                        </div>
                        <div class="breadcrumbsItem">
                            <a href="{{ route('articles.list') }}" title="Voir toutes les articles">Blog</a>
                        </div>
                        <div class="breadcrumbsItem breadcrumbsDesktopItem">
                            {{ $article->category->name }}
                        </div>
                    </div>
                </div>

                <h1 class="text-4xl font-semibold">{{ $article->title }}</h1>

                <p class="resume">
                    {{ $article->resume }}
                </p>
            </header>
        </div>

        <main class="w-full space-y-12 max-w-screen-xl mx-auto pt-6 pb-16 px-10">

            <section id="article_content" class="w-full space-y-8">
                @foreach($elements as $element)
                    @include('article.template.'.$element->type->template_name, ['element' => $element])
                @endforeach
            </section>

        </main>


        <footer class="w-full space-y-12 max-w-screen-xl mx-auto pt-6 pb-16 px-24">
            PARTAGER L'ARTICLE SUR
            <div class="mt-5 flex gap-5">
                <button class ="btnSocial flex justify-center items-center py-5 share_facebook shareF"
                data-url="">
                    <img src="{{ asset('images/social/facebook-app-symbol.png') }}" alt="facebook">
                </button>
                <button class ="btnSocial flex justify-center items-center py-5 share_twitter shareT"
                data-url="">
                    <img src="{{ asset('images/social/003-twitter-1.png') }}" alt="twitter">
                </button>
                <button class ="btnSocial flex justify-center items-center py-5 share_linkedin shareL"
                data-url="">
                    <img src="{{ asset('images/social/006-linkedin-5.png') }}" alt="linkedin">
                </button>
            </div>
        </footer>


    </div>



@endsection

@push('end-body')
    <script src="{{ asset('js/social.js') }}"></script>
@endpush
