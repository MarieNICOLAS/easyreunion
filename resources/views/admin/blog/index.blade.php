@extends('layouts.app')

@section('content')

    <div class="mainContent">


        <div class="float-right mr-6">
            <a href="{{ route('admin.blog.create') }}" class="btn info mx-2 btn-active h-in">Nouvel article</a>
        </div>

        <h3>Articles du blog</h3>

        <table class="min-w-full divide-y divide-gray-200 mb-4">
            <thead class="bg-blue-back">
            <tr>
                <th>Parution</th>
                <th>Catégorie</th>
                <th>Titre</th>
                <th>Statut</th>
                <th></th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($articles as $article)
                    <tr>
                        <td>{{ $article->getPublicatedAt()->format('d/m/Y') }}</td>
                        <td>{{ $article->category->name }}</td>
                        <td>{{ $article->title }}</td>
                        <td>{{ $article->status }}</td>
                        <td>
                            <a href="{{ route('admin.blog.edit', ['article_id' => $article->id]) }}">VOIR</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>

    </div>



@endsection

@push('end-body')
@endpush
