@extends('layouts.app')

@section('title', 'Gestion des pages')

@section('content')
    <h3>Gestion des pages</h3>
    <div class="flex flex-col w-11/12">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 rounded-lg w-screen">
                    <table class="divide-y divide-gray-200">
                        <thead class="bg-blue-back">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">
                                Nom
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium  uppercase tracking-wider">
                                Action
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-50 uppercase tracking-wider">
                                Description
                            </th>
                            
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach(\App\Models\Page::all() as $page)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900">
                                            <a href="">{{ $page->title }}</a>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                    <a href="{{ route('admin.pages.edit', $page) }}"
                                       class="btn dark h-in">Modifier</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div
                                        class="text-sm text-gray-900">{{ strip_tags(substr($page->content, 0, 60)) }}
                                        ...
                                    </div>
                                </td>

                                

                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
