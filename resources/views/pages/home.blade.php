@extends('layouts.front')

@section('content')

    <div class="flex justify-center h-[calc(100vh-72px)] lg:h-[calc(100vh-112px)] bg-center bg-no-repeat bg-cover"
        style="background-image: url({{asset('assets/hero-bg.jpeg')}})">
        <img src="{{asset('assets/logo_araceli.png')}}" class="h-48 lg:h-96 my-auto" title="Logo Araceli"
            alt="Logo Araceli" />
    </div>

@endsection