@extends('layouts.app')

@section('content')
    <div class="space-y-10 m-6">
        <h1 class="text-4xl font-bold text-center lg:text-left text-blue-primary">Mise à jour d'offre d'emploi</h1>
        @if(count($errors) > 0)
            @include('_partials.alerts.errors', ['errors' => $errors->all()])
        @endif
        <form
            class="m-3 flex flex-col items-start"
            method="POST" action="{{ route('admin.job-offers.update', $job) }}">
            @csrf
            @method('PUT')

            <div class="flex flex-col w-full lg:w-3/4 space-y-2 mb-1">
                <label class="text-xl text-center lg:text-left" for="title">Titre de l'offre d'emploi</label>
                <input required
                       class="shadow-sm w-full focus:ring-light-blue-500 focus:border-light-blue-500 border-gray-300 rounded-md mr-1"
                       type="text" name="title" value="{{ old('title') ?? $job->title }}"/>
            </div>

            <div class="flex flex-col align-items w-full lg:w-3/4 my-10 lg:my-8 space-y-2">
                <label
                    class="text-xl mb-1 text-center lg:text-left"
                    for="name">Description de l'offre d'emploi
                </label>
                <textarea
                    required
                    id="editor"
                    name="description">{{  old('description') ?? $job->description }}
                </textarea>
            </div>

            <div class="mb-10 lg:mb-5 w-full text-center lg:text-left space-y-2">
                <label
                    for="active">Visibilité :</label>
                <select
                    class="block lg:inline w-full lg:w-1/6 shadow-sm focus:ring-light-blue-500 focus:border-light-blue-500 sm:text-sm border-gray-300 rounded-md mr-1 text-gray-500"
                    name="active">
                    <option value="true" {{ $job->active ? 'selected' : '' }}>Visible</option>
                    <option value="false" {{ $job->active ? '' : 'selected' }}>Invisible</option>
                </select>
            </div>

            <div class="w-full text-center lg:text-left">
                <input
                    class="btn info h-in"
                    type="submit"
                    value="Éditer"
                />
            </div>

        </form>
    </div>
@endsection
@push('end-body')
    <script src="https://cdn.ckeditor.com/ckeditor5/28.0.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor.create(document.querySelector('#editor'))
    </script>

@endpush
