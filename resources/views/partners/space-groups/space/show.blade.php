@extends('layouts.app')

@section('content')
    <main>
        <section class="container">
            <h2><strong>{{ $space->name }}</strong>

                @can('update', $space->spaceGroup)
                    <a class="text-sm font-normal btn info h-in mx-2" href="{{ route('partner.spaces.edit', $space) }}">Mettre
                        à
                        jour</a>
                @endcan
            </h2>

            <div class="">
                <p class="col-span-2 pr-6">{!! $space->presentation !!}</p>
                <div class="grid grid-cols-2 gap-x-4 gap-y-8">
                    @foreach($space->tags as $tag)
                        <div class="border-t-2 border-gray-100 pt-6">
                            <dt class="text-base font-medium easy-DarkBlue">{{ __('tags.'.$tag->name) }}</dt>
                        </div>
                    @endforeach
                </div>
            </div>


            <div class="mt-6">
                <h1>Actions</h1>
                @if(session('success'))
                    @include('_partials.alerts.success', ['success' => session('success')])
                @endif
                <table>
                    <thead>
                    <tr>
                        <th>Contenu</th>
                        <th>Créé par</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($space->actions()->pending()->get() as $action)
                        <tr>
                            <td>{{ $action->content }}</td>
                            <td>{{ $action->author?->name }}</td>
                            <td>{{ $action->created_at }}</td>
                            <td><a
                                    href="{{ route('partner.actions.toggle-completed', $action) }}">Marquer comme
                                    terminé</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <h4 class="mt-6 mb-2">Ajouter une action</h4>

                @if($errors->count() > 0)
                    @include('_partials.alerts.errors', ['errors' => $errors->all()])
                @endif


                <form method="POST" action="{{ route('spaces.actions.store', $space) }}">
                    @csrf

                    <div class="form-group">
                        <label for="content">Contenu</label>
                        <textarea required id="content" name="content"></textarea>
                    </div>

                    <input class="btn success h-in" type="submit" value="Ajouter"/>
                </form>

            </div>

        </section>
    </main>
@endsection
