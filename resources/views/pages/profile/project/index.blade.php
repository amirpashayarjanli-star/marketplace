@extends('layouts.app')

@section('title', $project->name ?? 'پروژه آسانسور')

@section('content')

<main>

    <div class="container-app">

        <h1>
            {{ $project->name ?? 'پروژه آسانسور' }}
        </h1>


        @if($project->city)

            <p>
                شهر:
                {{ $project->city }}
            </p>

        @endif


        @if($project->description)

            <p>
                {{ $project->description }}
            </p>

        @else

            <p>
                توضیحات این پروژه هنوز ثبت نشده است.
            </p>

        @endif


    </div>

</main>

@endsection
