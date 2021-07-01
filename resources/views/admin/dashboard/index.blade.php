@extends('layouts.dashboard')
@section('content')
<div class="container-fluid">
    <div class="row card-row">
        <div class="col-12">
            <h1 class="tab-title">Benvenuto, {{Auth::user()->name}}</h1>
            <h3>Le tue statistiche generali</h3>
        </div>
        {{-- CARD STAT : APPARTAMENTI---- --}}
        <div class="col-lg-3 col-md-6" >
            <a class="card-link" href={{ route('apartments.index')}}>
                <div class="card card-stats" >
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">           
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="3em" height="3em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none" stroke="#626262" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7l9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><path d="M9 22V12h6v10"/></g></svg>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="card-category" >Appartamenti</p>
                                    <h3 class="card-title">{{$apartments}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <hr>
                        <div class="stats">
                            <i>Totale Appartamenti</i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    
        {{-- CARD STAT : VISUALIZZAZIONI---- --}}
        <div class="col-lg-3 col-md-6">
            <a class="card-link" href={{ route('admin.statistics.index' , ['id_apt' => '-1'])}}>
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">           
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="3em" height="3em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none" stroke="#626262" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8s11 8 11 8s-4 8-11 8s-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></g></svg>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="card-category">Visualizzazioni</p>
                                    <h3 class="card-title">{{$views->count()}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <hr>
                        <div class="stats">
                            <i>Totale visualizzazioni</i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    
        {{-- CARD STAT : MESSAGGI---- --}}
        <div class="col-lg-3 col-md-6">
            <a class="card-link" href={{ route('messages.index', ['id_apt' => '-1'])}}>
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">           
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="3em" height="3em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none" stroke="#626262" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><path d="M22 6l-10 7L2 6"/></g></svg>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="card-category">Messaggi</p>
                                    <h3 class="card-title">{{$messages}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <hr>
                        <div class="stats">
                            <i>Totali ricevuti</i>
                        </div>
                    </div>
                </div>
            </a>
    
        </div>
        
        {{-- CARD STAT : SPESE---- --}}
        <div class="col-lg-3 col-md-6">
            <a class="card-link" href={{ route('admin.sponsorships.index')}}>
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">           
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="3em" height="3em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none" stroke="#626262" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1v22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></g></svg>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="card-category">Sponsorizzazioni</p>
                                    <h3 class="card-title">{{$sponsored_apartments}} €</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <hr>
                        <div class="stats">
                            <i>Totale speso</i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <h3>Le tue visualizzazioni questo mese</h3>
        </div>
        {{-- CHART ANDAMENTO Visualizzazioni--}}
        <div class="col-12">
            <div class="card card-chart">

                {{-- titolo Chart --}}
                <div class="card-header">
                    <h5 class="card-category">Visualizzazioni totali</h5>
                    <h3 class="card-title">
                        <i>{{$views->count()}}</i>
                    </h3>
                </div>

                {{-- body chart --}}
                <div class="card-body">
                    <div class="chart-area">
                        <admin-statistics-chart-all
                            :views={{$views}}
                        />
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection