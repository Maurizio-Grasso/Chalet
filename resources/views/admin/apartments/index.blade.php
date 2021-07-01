@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="tab-title">Appartamenti</h1>
            <p>Qui puoi visualizzare, modificare o cancellare i tuoi appartamenti</p>
        </div>

        <div class="col-12 text-right">
            <a href="{{ route('apartments.create') }}" class="btn btn-our-btn">
                Inserisci nuovo appartamento
            </a>
        </div>
        <div class="col-12">
            <h3>Lista appartamenti</h3>
            <table class="table table-striped">
                <thead>
                    <tr role="row">
                        <th tabindex="0" rowspan="1" colspan="1" aria-sort="ascending">Titolo</th>
                        <th class="d-none d-sm-table-cell" tabindex="0" rowspan="1" colspan="1">Località</th>
                        <th class="d-none d-sm-table-cell" tabindex="0" rowspan="1" colspan="1">Dimensioni</th>
                        <th class="d-none d-sm-table-cell" tabindex="0" rowspan="1" colspan="1">Prezzo</th>
                        <th class="d-none d-sm-table-cell" tabindex="0" rowspan="1" colspan="1">Stanze</th>
                        <th class="d-none d-sm-table-cell" tabindex="0" rowspan="1" colspan="1">Letti</th>
                        {{-- <th tabindex="0" rowspan="1" colspan="1">Bagni</th> --}}
                        <th class="d-none d-sm-table-cell"tabindex="0" rowspan="1" colspan="1">Visibile</th>
                        <th rowspan="1" colspan="1" class="action-bigger">Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($apartments as $apartment)
                        
                    {{-- riga appartamento --}}
                    <tr role="row">
                        <td class="sorting_1">
                            <img src="" alt="" class="rounded me-3">
                            <p class="m-0 d-inline-block align-middle font-16">
                                <a href="{{ route('apartments.show',$apartment->id)}}" class="text-body">{{ $apartment->title }}</a>
                                <br>
                                @for ($i = 0; $i < floor($apartment['rating']); $i++)
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87l1.18 6.88L12 17.77l-6.18 3.25L7 14.14L2 9.27l6.91-1.01L12 2z"></path>
                                        </svg>
                                    </span>
                                    
                                @endfor
                            </p>
                        </td>
                        <td class="d-none d-sm-table-cell text-left">{{ $apartment->address }}</td>
                        <td class="d-none d-sm-table-cell text-right">{{ $apartment->dimensions }} m<sup>2</sup></td>
                        <td class="d-none d-sm-table-cell text-right">{{ $apartment->price_per_night }} €</td>
                        <td class="d-none d-sm-table-cell text-right">{{ $apartment->rooms_n }}</td>
                        <td class="d-none d-sm-table-cell text-right">{{ $apartment->beds_n }}</td>
                        {{-- <td class="text-right">{{ $apartment->bathroom_n }}</td> --}}
                        <td class="d-none d-sm-table-cell text-right">
                            @if ( $apartment['visible'] == 1)
                                sì
                            @else
                                no   
                            @endif
                        <td class="text-center">
                            {{-- EDIT --}}
                            <a href="{{ route('apartments.edit', $apartment->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon><line x1="3" y1="22" x2="21" y2="22"></line></svg>
                            </a>
                            {{-- MESSAGES --}}
                            <a href="{{route('messages.index', $apartment->id)}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <path d="M22 6l-10 7L2 6"></path>
                                    
                                </svg>
                            </a>
                            {{-- STATISTICS --}}
                            <a href="{{ route('admin.statistics.index', $apartment->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2">
                                    <line x1="18" y1="20" x2="18" y2="10"></line>
                                    <line x1="12" y1="20" x2="12" y2="4"></line>
                                    <line x1="6" y1="20" x2="6" y2="14"></line>
                                </svg>
                            </a>
                            {{-- DELETE --}}
                            <a onclick="confirmDelete()" style="cursor:pointer" href="#popup-box">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                            </a>
                            {{-- <form class="d-inline-block" action="{{ route('apartments.destroy',$apartment->id) }}" method="post">
                                @csrf
                                @method('DELETE') --}}
                                {{-- <button onclick="confirmDelete()" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </button> --}}
                            {{-- </form> --}}
                        </td>
                    </tr>
            
                    @endforeach
                    
                </tbody>
            </table>

            
            
        </div>
    </div>
    {{-- POPUP ELIMINAZIONE APT----- --}}
    <div class="popup-box-delete-apt" id="popup-box">
        <div class="popup-block">
            <div class="popup-text-block">
                <p>Confermi l'eliminazione?</p>
                <button onclick="chiudi()" class="btn btn-secondary mb-3">Annulla</button>
                <form class="d-inline-block" action="{{ route('apartments.destroy',$apartment->id) }}" method="post">
                    @csrf
                    @method('DELETE') 
                <button class="btn btn-danger" type="submit">Sì</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

<script>

function chiudi() {
    document.getElementById('popup-box').style.visibility="hidden";
    
}

function confirmDelete() {
    document.getElementById('popup-box').style.visibility="visible";
}





</script>