<section class="max-w-screen-xl w-4/5 mx-auto space-y-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-x-6 gap-y-6 mx-auto">
        @foreach($content['exclusive'] as $space_group )
            @include('_partials.components.grid-space-groups', $space_group)
        @endforeach
    </div>
    <br/><br/>
</section>
