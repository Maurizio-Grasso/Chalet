@extends('layouts.dashboard-no-js')

@section('content')
<div class="container-fluid apartment-form-container">
    <div class="row">
        <div class="col-12 col-md-6">
            <h1 class="tab-title">Modifica ' {{ $apartment->title }} '</h1>
        </div>
        <div class="col-12 col-md-6">
            <a href="{{ route('apartments.index') }}" class="btn btn-sm btn-outline-primary mb-3 mb-sm-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><line x1="20" y1="12" x2="4" y2="12"></line><polyline points="10 18 4 12 10 6"></polyline></svg> o Torna Indietro
            </a>
        </div>
    </div>

    {{-- ROW FORM--------- --}}
    <div class="row">
        <div class="col-12">
            
            {{-- GESTIONE ERRORI --}}
            <div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        
            {{-- INIZIO FORM MODIFICA------------------- --}}
            {{-- enctype="multipart/form-data" serve epr caricare le img --}}
            <form action="{{ route('apartments.update', ['apartment' => $apartment->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
        
                {{-- TITOLO-------- --}}
                <div class="form-group">
                    <label>Titolo</label>
                    <input type="text" name="title" class="form-control form-control-lg @error('title') is-invalid @enderror" placeholder="Inserisci il titolo" value="{{ old('title', $apartment->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
        
                {{-- INDIRIZZO-------- --}}
                <div class="form-group">
                    <label>Indirizzo</label>
                    <input type="text" name="address" class="form-control form-control-lg @error('address') is-invalid @enderror" placeholder="Inserisci l'indirizzo" value="{{ old('address', $apartment->address) }}" required readonly>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
        
                {{-- LATITUDINE E LONGITUDINE --}}
                <div class="row">
                    {{-- LATITUDINE-------- --}}
                    <div class="form-group col">
                        <label>Latitudine</label>
                        <input type="number" name="latitude" min="0" class="form-control @error('latitude') is-invalid @enderror" value="{{ old('latitude', $apartment->latitude) }}" placeholder="Latitudine"readonly>
                        @error('latitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
        
                    {{-- LONGITUDINE------- --}}
                    <div class="form-group col">
                        <label>Longitudine</label>
                        <input type="number" name="longitude" min="0" class="form-control @error('longitude') is-invalid @enderror" value="{{ old('longitude', $apartment->longitude) }}" placeholder="Latitudine"readonly>
                        @error('longitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
        
                <div class="row">
        
                    {{-- PREZZO PER NOTTE---- --}}
                    <div class="form-group col">
                        <label>Prezzo/notte €</label>
                        <input type="number" name="price_per_night" min="0" class="form-control form-control-lg @error('price_per_night') is-invalid @enderror" value="{{ old('price_per_night', $apartment->price_per_night) }}" placeholder="Inserisci il prezzo in €" required>
                        @error('price_per_night')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
        
                    {{-- DIMENSIONI APPARTAMENTO------ --}}
                    <div class="form-group col">
                        <label>Dimensioni m<sup>2</sup></label>
                        <input type="number" name="dimensions" min="0" class="form-control form-control-lg @error('dimensions') is-invalid @enderror" value="{{ old('dimensions', $apartment->dimensions) }}" placeholder="Inserisci le dimensioni in mq" required>
                        @error('dimensions')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- STANZE------- --}}
                    <div class="form-group col-4 col-sm-2">
                        <label>N° stanze</label>
                        <input type="number" name="rooms_n" min="0" class="form-control form-control-lg @error('rooms_n') is-invalid @enderror" value="{{ old('rooms_n', $apartment->rooms_n) }}" placeholder="Inserisci il numero delle stanze" required>
                        @error('rooms_n')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
        
                    {{-- LETTI------ --}}
                    <div class="form-group col-4 col-sm-2">
                        <label>N° posti letto</label>
                        <input type="number" name="beds_n" min="0" class="form-control form-control-lg @error('beds_n') is-invalid @enderror" value="{{ old('beds_n', $apartment->beds_n) }}" placeholder="Inserisci il numero dei letti"required>
                        @error('beds_n')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
        
                    {{-- BAGNI-------- --}}
                    <div class="form-group col-4 col-sm-2">
                        <label>N° bagni</label>
                        <input type="number" name="bathroom_n" min="0" class="form-control form-control-lg @error('bathroom_n') is-invalid @enderror" value="{{ old('bathroom_n', $apartment->bathroom_n) }}" placeholder="Inserisci il numero dei bagni"required>
                        @error('bathroom_n')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
        
                
                
                {{-- DESCRIZIONE-------- --}}
                <div class="form-group">
                    <label>Descrizione</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="10" placeholder="Inserisci una descrizione" required>{{ old('description', $apartment->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <p>Seleziona i servizi:</p>
                    <div class="row ml-2 md-ml-3">
        
                        {{-- SERVIZI ------ --}}
                        @foreach ($services as $service)
                            <div class="col-6 col-sm-3 form-check @error('services') is-invalid @enderror">
                                <input name="services[]" class="form-check-input" id="services" type="checkbox" value="{{ $service->id }}"
                                {{ $apartment->services->contains($service) ? 'checked=checked' : '' }}>
                                <label class="form-check-label">
                                    {{ $service->service_name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('services')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
        
                {{-- IMMAGINI----- --}}
                {{-- <div class="form-group">
                    <label>Immagini</label> --}}
                    {{-- controlliamo se sono presenti immagini da mostrare
                    @if(qualcosa che controlli tabella ponte)
                        <img src="{{ asset('storage/'. e concateniamo il path img)}}" alt=""> --}}
        
        
                    {{-- multiple serve per mettere più immagini --}}
                    {{-- <input class='form-control-file' type="file" name="img_path" multiple>
                </div> --}}
        
                <label>Immagini:</label>
                <button type="button" name="add" id="add" class="btn btn-success">Add More</button>
                    <div class="row img-input-row" id="add_more">
                        
                        @for ($i = 0; $i < $n_img; $i++)
                        {{-- BLOCCO IMG-------  --}}
                        <div class= "col-6 col-sm-3 remove-img">

                            {{-- riquadro img------ --}}
                            <img id="{{ 'img' .($i+1) }}" src={{ '/storage/' .$images[$i]->img_path }} />
                            {{-- descrizione------ --}}
                            <input type="text" name="{{ 'img_description' .$images[$i]->id }}" placeholder="Descrizione" value="{{ old('img_description' .$images[$i]->id, $images[$i]->img_description) }}">
                            {{-- copertina--------- --}}
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="{{'is_cover' .($i+1)}}">
                                    Copertina
                                </label>
                                <input class="form-check-input" type="radio" name="is_cover" id="{{'is_cover' .($i+1)}}" class="form-control @error('is_cover') is-invalid @enderror" value="{{ $images[$i]->id }}" required {{ $images[$i]->is_cover == '1' ? 'checked=checked' : '' }}>
                            </div>
                            {{-- elimina img --}}
                            <input type="hidden" id="id_img" value="{{ $images[$i]->id }}">
                            <button type="button" class="btn btn-danger btn-sm remove-img-btn ">Cancella</button>
                                {{-- <a href="{{ route('remove.images', ['id' => $images[$i]->id]) }}"><button type="button" class="btn-danger">Delete</a> --}}
                    
                        </div>
                        @endfor
                        {{-- <div class="col-2">
                            <img id="img1" src="https://www.maniboo.it/wp-content/uploads/2019/11/no-image.jpg"/>
                            <input class='form-control-file' type="file" name="image1" id="img_input1">
                            <input type="text" name="img_description1" placeholder="Descrizione">
                            <p>Copertina</p>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_cover" id="is_cover1" class="form-control @error('is_cover') is-invalid @enderror" value="image1"  checked required>
                        </div> --}}
                        
                    </div>
        
                    <input type="hidden" name="n_img_now" id="n_img_now" value= "{{ $n_img }}">
                    <input type="hidden" name="n_img" id="n_img" value= "{{ $n_img }}">
                    <input type="hidden" name="n_img_del" id="n_img_del" value="">
        
        
                <p>Rendi Visibile:</p>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="visible" id="1" class="form-control @error('visible') is-invalid @enderror" value="1"  {{ $apartment->visible == '1' ? 'checked=checked' : '' }}>
                    <label class="form-check-label" for="1">
                      Sì
                    </label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="visible" id="1" class="form-control @error('visible') is-invalid @enderror" value="0"  {{ $apartment->visible == '0' ? 'checked=checked' : '' }} >
                    <label class="form-check-label" for="0">
                      No
                    </label>
                    @error('visible')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
            
        
                <div class="form-group">
                    <button type="submit" class="btn btn-success mt-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg> Salva 
                    </button>
                </div>
            </form>
        </div>
    </div>
     
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>


var i = document.getElementById("n_img_now").value;
var array = [];
$("#add").click(function(){
 if($('#img'+i).attr('src')!= "https://www.maniboo.it/wp-content/uploads/2019/11/no-image.jpg"){
    ++i; 

    $("#add_more").append('<div class="col-2 remove-div"><img id="img'+i+'" src="https://www.maniboo.it/wp-content/uploads/2019/11/no-image.jpg"/><input class="form-control-file" type="file" name="image'+i+'" id="img_input'+i+'"><input type="text" name="img_description'+i+'" placeholder="Descrizione"><p>Copertina</p><div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="is_cover" id="is_cover'+i+'" class="form-control @error('is_cover') is-invalid @enderror" value="image'+i+'" required></div><button type="button" class="btn btn-danger remove-input">Remove</button></div>');

    document.getElementById("n_img_now").setAttribute('value', i);

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img'+i).attr('src', e.target.result);
            }
    
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#img_input"+i).change(function(){
        readURL(this);
    });
 }
});


    $(document).on('click', '.remove-input', function(){  
        $(this).parents('.remove-div').remove();
        document.getElementById("is_cover1").checked=true;

    });  

    $(document).on('click', '.remove-img-btn', function(){  
        var index = document.getElementById('id_img').value;
        array.push(index);
        document.getElementById('n_img_del').setAttribute('value', array);
        $(this).parents('.remove-img').remove();
    });  



</script>


@endsection
