@extends('layouts.app')

@section('content')

    {{ csrf_field() }}

    @php
        $count = 0;
    @endphp

    <div class="mainContent" style="position: relative">

        <div id="message" style="display: none">
        </div>

        <div class="float-right mr-6">
            <a href="{{ route('admin.blog.article.update') }}" class="btn info mx-2 btn-active h-in" id="saveButton">Sauvegarder</a>
            @if($article->slug)
                <a href="{{ route('articles.show', $article->slug) }}" class="btn success mx-2 btn-active h-in"
                   target="_blank">Voir</a>
            @endif
        </div>

        <h3>Créer un nouvel article</h3>

        <br/>


        <div id="editBlogArticle">

            <input type="hidden" name="blog_article_id" id="blog_article_id" value="{{ $article->id }}"
                   class="formElement"/>

            <div class="contentBloc">
                <div class="mainPart">
                    <div class="row">
                        <label class="text-xl mb-1 text-center">
                            Titre de l'article
                        </label>
                        <input type="text" name="blog_title" id="blog_title" placeholder="Titre de l'article"
                               value="{{ $article->title }}" class="formElement"/>
                    </div>
                    <div class="row">
                        <label class="text-xl mb-1 text-center">
                            Permalien
                        </label>
                        <input type="text" name="blog_slug" id="blog_slug" placeholder="Permalien"
                               value="{{ $article->slug }}" class="formElement"/>
                    </div>
                    <div class="row">
                        <label class="text-xl mb-1 text-center">
                            Résumé
                        </label>
                        <br/>
                        <textarea name="blog_resume" id="blog_resume" placeholder="Résumé"
                                  class="formElement">{{ $article->resume }}</textarea>
                    </div>

                    <div class="row">
                        <label class="text-xl mb-1 text-center">
                            Ajouter une photo de couverture
                        </label>
                        <input type="file" id="blog_article_cover_img" accept="image/jpeg, image/png, image/jpg">
                        <input type="hidden" id="blog_article_image" class="formElement">
                        <input type="hidden" id="blog_article_image_url"
                               value={{ $article->cover_img }} class="formElement">
                        @if($article->cover_img)
                            <div id="display-image"
                                 style="background-image: url('{{ URL::asset($article->cover_img) }}')"></div>
                        @else
                            <div id="display-image" style="display: none"></div>
                        @endif
                    </div>


                </div>

                <div class="rightPart">
                    <div class="row">
                        <label class="text-xl mb-1 text-center lg:text-left">
                            Date de publication
                        </label>
                        <input type="date" name="blog_publicated_at" id="blog_publicated_at"
                               value="{{ $article->getPublicatedAt()->format('Y-m-d') }}" class="formElement"/>
                    </div>

                    <div class="row">
                        <label class="text-xl mb-1 text-center lg:text-left">
                            Statut
                        </label>
                        <select name="blog_status" id="blog_status" class="formElement">
                            <option value="draft" {{  $article->status === "draft" ? "selected" : "" }}>Brouillon
                            </option>
                            <option value="toreread" {{  $article->status === "toreread" ? "selected" : "" }}>A relire
                            </option>
                            <option value="online" {{  $article->status === "online" ? "selected" : "" }}>En ligne
                            </option>
                        </select>
                    </div>

                    <div class="row" style="position: relative">
                        <label class="text-xl mb-1 text-center lg:text-left">
                            Catégorie
                        </label>
                        <input type="text" name="blog_category_name" placeholder="Catégorie" id="blog_category_name"
                               value="{{ $article->id != null ? $article->category->name : "" }}" class="formElement"/>
                        <input type="hidden" name="blog_category_id" id="blog_category_id"
                               value="{{ $article->id != null ? $article->category->id : "" }}" class="formElement"/>

                        <div id="category_name_list" style="display: none;">
                            <ul>
                            </ul>
                        </div>

                    </div>

                </div>

            </div>

            <div id="blogArticleContentElement">

                @if($elements)
                    @foreach($elements as $element)
                        @php
                            $count++;
                        @endphp
                        @include('admin.blog.template.'.$element->type->template_name, ['element' => $element])
                    @endforeach
                @endif
            </div>

            <br/>

            <h4>Ajouter un bloc</h4>
            <div class="contentBloc">
                @foreach($elementTypes as $type)
                    <a href="{{ route('admin.blog.article.update.element') }}"
                       class="btn btn-active h-in success mx-2 addElementTypeButton" data-typeid="{{ $type->id }}"
                       data-type="{{ $type->template_name }}">{{ $type->name }}</a>
                    <div id="template_{{ $type->template_name }}" style="display: none;">
                        @include("admin.blog.template.".$type->template_name, ['element' => null] )
                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endsection

@push('end-body')
    <script>
        var urlUpdateElement = "{{ route('admin.blog.article.update.element') }}";
        var urlDeleteElement = "{{ route('admin.blog.article.delete.element') }}";
        var urlCategoryList = "{{ route('admin.blog.article.category.list') }}";
        var originalCount = "{{ $count }}";
    </script>
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script src="{{ asset('js/blogEdit.js') }}"></script>
@endpush
