@extends('layouts.app')

@section('content')
    <div class="flex flex-col lg:px-10 lg:py-2">
        <h1>Utilisateurs</h1>

        <select id="selectTypeUser">
            <option value="{{ route('admin.users.status', "all") }}" {{ $status == "all" ? "selected" : "" }}>Tous les utilisateurs</option>
            <option value="{{ route('admin.users.status', "active") }}" {{ $status == "active" ? "selected" : "" }}>Tous les actifs</option>
            <option value="{{ route('admin.users.status', "unactive") }}" {{ $status == "unactive" ? "selected" : "" }}>Tous les inactifs</option>
        </select>
        <br/>
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Organisation
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dernière connexion
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Compte créé le
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr class="{{ $loop->odd ? "bg-white" : "bg-gray-50" }} {{ $user->active == 0 ? "bg-red" : " " }} cursor-pointer"
                                onclick="window.location = '{{ route('admin.users.show', $user) }}'">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ ($user->organization) ? $user->organization->name : ''}}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->last_login }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->created_at->format('d/m/Y H:i:s') }}
                                </td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
        <h1 class="mt-10">Administrateurs</h1>
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dernière connexion
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Compte créé le
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($admins as $user)
                            <tr class="{{ $loop->odd ? "bg-white" : "bg-gray-50" }} cursor-pointer"
                                onclick="window.location = '{{ route('admin.users.show', $user) }}'">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->last_login }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->created_at->format('d/m/Y H:i:s') }}
                                </td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                </div>
                <form class="mt-4 md:w-1/2" method="POST" action="{{ route('admin.team.invite') }}">
                    @csrf
                    <h3>Ajouter un administrateur</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom</label>
                            <input name="first_name" type="text" value="{{ old('first_name') }}"/>
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="block text-sm font-medium text-gray-700">Nom</label>
                            <input name="last_name" type="text" value="{{ old('last_name') }}"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input name="email" type="email" value="{{ old('email') }}"/>
                    </div>


                    <input class="btn success ml-2 h-in" type="submit" value="Ajouter"/>
                </form>

            </div>

        </div>
    </div>

@endsection

@push('end-body')

    <script>
        let selectType = document.getElementById('selectTypeUser');

        selectType.addEventListener('change', function(event) {
            let url = event.target.value;
            window.location = url;
        });

    </script>

@endpush
