<section class="max-w-screen-xl w-4/5 mx-auto space-y-12">

    <div class="space-y-2">
        <h2 class="my-20 text-center">Trouvez rapidement votre salle</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-6 mx-auto">
        @foreach($content['featured'] as $space_group )
            @include('_partials.components.grid-space-groups', $space_group)
        @endforeach
    </div>

    @include('guest._home.bloc_easy2')

</section>
