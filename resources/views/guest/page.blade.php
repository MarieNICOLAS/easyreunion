@extends('layouts.app-front')

@section('title', $page->title)
@section('meta-description', ($page->meta === "" || $page->meta === null) ? trim(str_replace(['&amp;', '&nbsp;', '&amp;eacute;'], ['','', 'é'], substr(strip_tags($page->content), 0,100))): $page->meta)
@section('canonical', Request::url() )


@section('content')
<div class="headinSet flex-col easy-bg2">
        <span class="mx-auto text-[6vw] leading-none sm:text-5xl bannerTxtAnimeL">{{  $page->banner_title }}</span>
</div>
    <main class="page pt-8">
        
        {!! $page->content !!}

        @if($page->children)
            <div class="grid md:grid-cols-2 mt-12">
                @foreach($page->children as $childPage)
                    <div
                        class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                        <div class="flex-shrink-0">
                            <img class="h-48 w-48 object-cover" src="{{ $childPage->media?->first()?->url }}" alt="{{ $childPage->media?->first()?->alt }}">
                        </div>
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('page.show', $childPage) }}" class="focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <p class="text-sm font-medium text-gray-900">{{ $childPage->title }}</p>
                                <p class="text-sm text-gray-500 truncate">{{ $childPage->meta }}</p>
                            </a>
                        </div>
                    </div>

                @endforeach
            </div>
        
        @endif
        @if($page->media->count() > 0)
            <div>
                @include('_partials.components.grid-room-by-tags')
                @include('_partials.components.slider', ['images' => $page->media->pluck('url'), 'mediaData' => $page->media])
            </div>
        @endif
    </main>
@endsection

