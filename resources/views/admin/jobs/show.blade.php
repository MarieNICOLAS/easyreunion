@extends('layouts.app')
@section('content')

    @if(Session::has('success'))
        <div class="rounded-md bg-green-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                         fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                              clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">
                        {{Session::get('success')}}
                    </p>
                </div>
            </div>
        </div>
    @endif
    <div class="space-y-6 mx-6 my-6">
        <h1 class="text-4xl font-bold text-center lg:text-left text-blue-primary">{{ $job->job_title }}</h1>
        <p class="text-justify">{!! old('description') ?? $job->description !!}  </p>
        <a class="btn info" href="{{ route('admin.job-offers.edit', $job) }}">Éditer</a>
    </div>
@endsection
