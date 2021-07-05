@extends('layouts.guest')

@section('title', 'Dettagli Appartamento | Sciallé')

@section('headPush')

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
    crossorigin=""/>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>
    
@endsection

    @php

    if(isset($_GET['messageSent']))        
        $messageSent=true;
     else $messageSent=false;
    
    @endphp

@section('main')
                    
    <main class="main-standard">


        {{-- 
            Sezione Intestazione 
            (titolo, valutazione e indirizzo dello chalet) 
        --}}

        <section class="apt-heading">

            <h1 class="heading--primary apt-heading__title">{{$apartment['title']}}</h1>

            <div class="apt-heading__rating">

                <span>Voto: {{$apartment['rating']}}/5 </span>
                
                @for ($i = 0; $i < ceil($apartment['rating']); $i++)
                    <i class="fas fa-star"></i>
                @endfor

                @for ($i = 0; $i < (5 - ceil($apartment['rating'])); $i++)
                    <i class="far fa-star"></i>
                @endfor
                
            </div>

            <span class="apt-heading__address"> Indirizzo: {{$apartment['address']}}</span>

        </section>{{-- Heading --}}


        {{-- 
            Sezione Con immagini dell'appartamento 
            Lo slider è un componente Vue
        --}}

        <section class="apt-slider">

            <img-slider :photos="{{json_encode($apartment['images'])}}"></img-slider>

            <hr>

        </section>

        
        {{-- 
            Sezione Principale della Pagina
            Contiene le informazioni dettagliate dello chalet
            ed il form per contattare l'host 
        --}}

        <section class="main-section ">

            <div class="outer-sticky-container">
                
                <section class="apt-info">

                    <div class="host-box">
                        
                        <div class="host-box__bio">
                            <h3 class="host-box__name">Host: {{ $apartment['host']['name']}} {{ $apartment['host']['surname'] }}</h3>
                            <span class="host-box__date">Membro da: Luglio 2016</span>
                        </div>
                        
                        <img class="host-box__photo" src="{{'/' . $apartment['host']['profile_pic']}}" alt="{{ $apartment['host']['name']}} {{ $apartment['host']['surname'] }}">
                        
                    </div>

                    <hr>
                    
                    <ul class="apt-facilities__list">
                        
                        <li class="apt-facilities__single">
                            <i class="apt-facilities__icon fas fa-home"></i>
                            <h4 class="apt-facilities__name">casa intera</h4>
                            <p class="apt-facilities__description">Appartamento:sarà a tua completa disposizione</p>
                        </li>
                        
                        <li class="apt-facilities__single">                        
                            <i class="apt-facilities__icon fas fa-bed"></i>
                            <h4 class="apt-facilities__name">
                                @if($apartment['rooms_n'] ==1) 1 Camera @else {{$apartment['rooms_n']}} Camere @endif da Letto
                            </h4>
                            <p class="apt-facilities__description">Questo chalet dispone di @if($apartment['rooms_n'] ==1) 1 Camera @else {{$apartment['rooms_n']}} Camere @endif</p>
                        </li>
                        
                        <li class="apt-facilities__single">                        
                            <i class="apt-facilities__icon fas fa-user-friends"></i>
                            <h4 class="apt-facilities__name">
                                @if($apartment['beds_n'] ==1) 1 Ospite @else {{$apartment['beds_n']}} Ospiti @endif
                            </h4>
                            <p class="apt-facilities__description">Può ospitare fino a @if($apartment['beds_n'] ==1) 1 Persona @else {{$apartment['beds_n']}} Persone @endif</p>
                        </li>
                        
                        <li class="apt-facilities__single">
                            <i class="apt-facilities__icon fas fa-shower"></i>
                            <h4 class="apt-facilities__name">
                                @if($apartment['bathroom_n'] ==1) 1 Bagno @else {{$apartment['bathroom_n']}} Bagni @endif                            
                            </h4>
                            <p class="apt-facilities__description">Asciugamani e prodotti per la pulizia sempre inclusi.</p>
                        </li>
                        
                    </ul>

                    <hr>
                    
                    <div class="apt-description">
                        <h3 class="heading--primary">Descrizione Chalet</h3>
                        {!!$apartment['description']!!}
                    </div>
                    
                    <hr>
                    
                    <div class="additional-services">
                        
                        <h3 class="heading--primary">Servizi Inclusi</h3>
                    
                        <ul class="additional-services__list">
                        
                            @foreach ($apartment['services'] as $service)
                            
                                <li class="additional-services__item">
                                    <i class="additional-services__icon fas fa-{{$service['service_icon']}}"></i>
                                    <span class="additional-services__name">{{$service['service_name']}}</span>
                                </li>                            
                            
                            @endforeach
                        
                         </ul>
                         
                    </div>
                
                </section>

                <section class="sticky-area">
                    
                    <div id="form-anchor" class="form contact-form">
                        
                        <form action="{{ route('saveMessage') }}" method="post" enctype="multipart/form-data">
                            
                            @csrf
                            
                            <h3 class="heading--primary">Contatta l'host per conoscere i dettagli</h3>
                            
                            @php
                                use Illuminate\Support\Facades\Auth;
                                $isLoggedIn = Auth::check() ? true : false;
                                @endphp

                            <div class="form__field">
                                <input type="email" name="email_sender" class="form__input" placeholder="Inserisci email" value="{{$isLoggedIn ? Auth::user()->email : null }}" required>
                                {{-- @error('email_sender')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror --}}
                            </div>

                            <div class="form__field">
                                <textarea class="form__input" name="message_text" id="message_text" name="message_text" placeholder="Scrivi un messaggio per il proprietario" required minlength="50"></textarea>
                                {{-- @error('message_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror --}}
                            </div>
                            
                            <button class="btn btn--primary" type="submit">Invia Messaggio</button>
                            
                            <div class="form__field">
                                <input type="hidden" name="apartment_id" value="{{ $apartment['id'] }}">
                            </div>
                            
                        </form>
                        
                    </div> {{-- form outer --}}
                    
                </section>{{-- Sticky Area --}}
            
            </div>{{-- Outer Sticky Container --}}
            
            <hr>

        </section>{{-- main section --}}
        

        {{-- 
            Sezione Position 
            mappa e localizzazione dello chalet
        --}}

        <section class="apt-position">
            
            <div class="map-title">

                <h3 class="heading--primary">Posizione</h3>
                
                <p class="apt-position__address">{{$apartment['address']}}</p>
                
                <p class="apt-position__coordinates">
                    <span><strong class="color-primary">Lat: </strong>{{$apartment['latitude']}}</span> <span><strong class="color-primary">Lon: </strong>{{$apartment['longitude']}}</span>
                </p>
                
            </div>
            
            <single-chalet-map
                :longitude="{{$apartment['longitude']}}" 
                :latitude="{{$apartment['latitude']}}">
    
                <!-- Mappa -->

            </single-chalet-map>

            <hr>

        </section>


        {{-- 
            Sezione Bottom Info
            Contiene riepilogo dell'host, warning message
            e call to action 
        --}}


        <section class="bottom-info">

            <div class="bottom-info__inner">
                <div class="host-box">
                        
                    <div class="host-box__bio">
                        <h3 class="host-box__name">Host: {{ $apartment['host']['name']}} {{ $apartment['host']['surname'] }}</h3>
                        <span class="host-box__date">Membro da: Luglio 2016</span>
                    </div>

                    <img class="host-box__photo" src="{{'/' . $apartment['host']['profile_pic']}}" alt="{{ $apartment['host']['name']}} {{ $apartment['host']['surname'] }}">
                </div>

                <div class="bottom-info__warning">
                    <p>Tanti Chalet simili a <span class="color-primary">{{$apartment['title']}}</span> sono già al completo sul nostro sito. Non farti sfuggire questa occasione e prenota subito a soli <span class="color-primary">{{$apartment['price_per_night']}}&euro;</span> a notte, senza commissioni e con cancellazione gratuita*!</p>
                </div>

                <div class="bottom-info__btn">

                    <a href="#form-anchor" class="btn btn--primary host-btn">
                        Contatta l'host ora
                    </a>
                </div>
            </div>

            <hr>

        </section>


        {{-- 
            Sezione Appartamenti Sponsorizzati
            Contiene slider con card di appartamenti sponsorizzati 
        --}}


        <section class=" sponsored-apt">
            
            <h3 class="heading--primary">Altri chalet in evidenza</h3>

            <p class="sponsored-apt__text">Ti piace ma non sei del tutto sicuro? Da' un'occhiata anche a questi chalet, selezionati fra le migliori opzioni oggi esistenti in Italia!</p>

            <sponsored-slider>

                {{-- Sponsored Apartments Slider --}}

            </sponsored-slider>

        </section>
    
    </main>

    <back-to-top></back-to-top>

    @endsection
    
    @if ($messageSent)

    <aside class="msgSent">
        <div class="msgSent__inner-box">
            <h2 class="msgSent__title">Messaggio inviato</h2>
            <p class="msgSent__text">Il tuo messaggio è stato correttamente inoltrato a <span class="color-primary">{{ $apartment['host']['name']}}</span>. Riceverai una risposta al più presto.</p>
            <button id="msgSent__button" class="msgSent__button btn btn--primary-light">Ok</button>
        </div>
    </aside>
    
    <script>
        document.querySelector('.msgSent__button').addEventListener("click", function(){
            document.querySelector('.msgSent').classList.add('hidden');
            });
    </script>
    
    @endif
