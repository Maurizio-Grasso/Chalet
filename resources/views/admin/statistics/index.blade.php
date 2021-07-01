@extends('layouts.dashboard')

@section('content')

<admin-statistics-page
    :apartments= "{{$apartments}}"
    :views="{{$views}}"
    :messages="{{$messages}}"
    :sponsorships="{{$sponsorships}}"
    :id_apt="{{$id_apt}}">
</admin-statistics-page>

@endsection