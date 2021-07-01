@extends('layouts.dashboard')

@section('content')

<admin-sponsorships-page 
:apartments="{{ $apartments }}"
:sponsored_apartments="{{ $sponsored_apartments}}"
:sponsorships="{{$sponsorships}}">
</admin-sponsorships-page>



@endsection