@extends('layouts.dashboard')

@section('content')

<admin-messages-page
:apartments= "{{$apartments}}"
:messages="{{$messages}}"
:id_apt="{{$id_apt}}"
/>

@endsection