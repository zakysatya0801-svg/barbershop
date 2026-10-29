@extends('layouts.public')

@section('content')
    @include('home.components.hero')
    @include('home.components.promo-banner')
    @include('home.components.services')
    @include('home.components.featured-barbers')
    @include('home.components.nearby-shops')
@endsection