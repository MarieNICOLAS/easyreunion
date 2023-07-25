@extends('layouts.app')

@section('title', 'Édition '.$page->title)

@section('content')
    @if(Session::has('success'))
        @include('_partials.alerts.success', ['success' => Session::get('success')])
    @endif
    @if(count($errors) > 0)
        @include('_partials.alerts.errors', ['errors' => $errors->all()])
    @endif

    <form method="POST" action="{{ route('admin.pages.update', $page) }}">
        @method('PUT')
        @csrf
        <div class="flex">
            <div class="md:w-2/3 pt-1">

                <textarea name="content" id="content">
                    {!! $page->content !!}
                </textarea>
            </div>
            <div class="md:ml-4">
                <div class="form-group">
                    <label for="title">Titre de la page</label>
                    <input type="text" id="title" name="title" value="{{ old('title') ?? $page->title }}"/>
                </div>

                <div class="form-group">
                    <label for="meta_title">Meta titre</label>
                    <input type="text" id="meta_title" name="meta_title"
                           value="{{ old('meta_title') ?? $page->meta_title }}"/>
                </div>


                <div class="form-group">
                    <label for="meta">Meta description</label>
                    <input type="text" id="meta" name="meta" value="{{ old('meta') ?? $page->meta }}"/>
                </div>

                <div class="form-group">
                    <label for="meta">Titre de la bannière</label>
                    <input type="text" id="banner_title" name="banner_title" value="{{ old('banner_title') ?? $page->banner_title }}"/>
                </div>

                <input type="submit" value="Mettre à jour" class="btn success h-in"/>
            </div>

        </div>
    </form>
@endsection

@push('end-body')
    @include('_partials.components.tinymce', ['selector' => '#content'])
@endpush
