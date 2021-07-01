@extends('layouts/guest')
@section('headPush')

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
    crossorigin=""/>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>
@endsection
@section('title' , 'Ricerca Chalet in tutta Italia | Sciallé')

@php

    // Controllo se esiste il parametro url 'location'

    if(isset($_GET['location'])){
        $destination = $_GET['location'];
    }
    else {
        $destination = 'bressanone';
    }
@endphp

@section('main')

<!-- Search page component -->
    
    <advanced-search-page destination="{{$destination}}">
        <!-- Search page component -->
    </advanced-search-page>


@endsection