@extends('layouts.app')

@section('content')
    <main class="px-2 pt-6 pb-24 sm:px-2 sm:pt-24 lg:px-4 lg:py-12">
        <div class="max-w-4xl mx-auto">
            <div class="max-w-3xl">
                <h1 class="text-sm font-semibold uppercase tracking-wide text-blue">Réservation
                    #{{ $booking->id }}</h1>
                <p class="mt-2 text-4xl font-extrabold tracking-tight sm:text-5xl">Réservation pour
                    le {{ \Carbon\Carbon::parse($booking->starts_at)->format('d M') }}</p>

                <!--                <dl class="mt-6 text-sm font-medium flex space-x-1 ">
                                    <a href="" class="text-blue btn success">Envoyer un message au client</a>
                                </dl>-->
            </div>

            <section aria-labelledby="order-heading" class="mt-10 border-gray-200">


                <h3 class="sr-only">Informations commande</h3>

                <h4 class="sr-only">Client</h4>
                <dl class="grid grid-cols-2 gap-x-6 text-sm py-10">
                    <div>
                        <dt class="font-medium text-gray-900">Client</dt>
                        <dd class="mt-2 text-gray-700">
                            <address class="not-italic">
                                <span class="block">{{ $booking->user->name }}</span>
                                <span class="block">{{ $booking->user->email }}</span>
                                <span class="block">{{ $booking->user->phone }}</span>
                            </address>
                        </dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-900">Info commande</dt>
                        <dd class="mt-2 text-gray-700">
                            <address class="not-italic">
                                <span
                                    class="block">Commande passée le  {{ \Carbon\Carbon::parse($booking->created_at)->format('d M') }}</span>
                                <span
                                    class="block">Date de début : {{ \Carbon\Carbon::parse($booking->starts_at)->format('d M') }}</span>
                                <span
                                    class="block">Date de fin : {{ \Carbon\Carbon::parse($booking->ends_at)->format('d M') }}</span>
                            </address>
                        </dd>
                    </div>
                </dl>

                <h2>Réservations</h2>
                <table>
                    <thead>
                    <tr>
                        <th>Salle</th>
                        <th>Début</th>
                        <th>Fin</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($booking->agendaElements as $element)
                        <tr>
                            <td>{{ $element->agenda->space->name }}</td>
                            <td>{{ $element->start }}</td>
                            <td>{{ $element->end }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>



            </section>
        </div>
    </main>

@endsection
