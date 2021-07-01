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

    if(isset($_GET['messageSent']) )        
        $messageSent=true;
     else $messageSent=false;
    
    @endphp

@section('main')
                    
    <main class="standard-padding">

        <div class="container">
            <section class="apartment-title">
                <h1 class="heading--primary">{{$apartment['title']}}</h1>
                <div class="rating-location">
                    <p> {{$apartment['rating']}} <i class="fas fa-star"></i> &#183 {{$apartment['address']}}</p>
                </div>
            </section>
        </div>

        <img-slider :photos="{{json_encode($apartment['images'])}}">

            {{-- slider immagini appartamento --}}

        </img-slider>

        <div class="container">
            <div class="form-container">
                <div class="left-container">

                    <section class="type-host">

                        <div class="little-description">
                            <h3 class="heading--primary">Host: {{ $apartment['host']['name']}} {{ $apartment['host']['surname'] }} </h3>
                            <p> 
                                
                                
                                @if($apartment['rooms_n'] ==1) 
                                    1 Camera 
                                @else 
                                    {{$apartment['rooms_n']}} Camere
                                @endif
                                &#183

                                @if($apartment['beds_n'] ==1) 
                                    1 Letto 
                                @else 
                                    {{$apartment['beds_n']}} Letti
                                @endif
                                &#183

                                @if($apartment['bathroom_n'] ==1) 
                                    1 Bagno 
                                @else 
                                    {{$apartment['bathroom_n']}} Bagni
                                @endif
                                &#183   
                                {{$apartment['dimensions']}}m<sup>2</sup>
                            </p>

                        </div>
                        <div class="host-img">
                            <img src="https://thumbs.dreamstime.com/b/default-avatar-profile-icon-vector-social-media-user-image-182145777.jpg"
                                alt="host-img">
                        </div>

                    </section>

                    <hr>

                    <section class="apartment-service">
                        <div class="service-card">
                            <div class="service-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="service-description">
                                <p class="font-weight--bold">Casa Intera</p>
                                <p>Appartamento:sarà a tua completa disposizione</p>
                            </div>
                        </div>

                        <div class="service-card">
                            <div class="service-icon">
                                <i class="fas fa-user-friends"></i>
                            </div>
                            <div class="service-description">
                                <p class="font-weight--bold">
                                    @if($apartment['beds_n'] ==1) 
                                    1 Ospite
                                    @else 
                                        {{$apartment['beds_n']}} Ospiti
                                    @endif
                                </p>
                                <p>Capienza fino a
                                    @if($apartment['beds_n'] ==1) 
                                    1 Ospite
                                    @else 
                                        {{$apartment['beds_n']}} Ospiti
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="service-card">
                            <div class="service-icon">
                                <i class="fas fa-house-user"></i>
                            </div>
                            <div class="service-description">
                                <p class="font-weight--bold">Monolocale</p>
                                <p>Tutto ciò che ti serve a portata di mano</p>
                            </div>
                        </div>

                        <div class="service-card">
                            <div class="service-icon">
                                <i class="fas fa-shower"></i>
                            </div>
                            <div class="service-description">
                                <p class="font-weight--bold">
                                    @if($apartment['bathroom_n'] ==1) 
                                    1 Bagno
                                    @else 
                                        {{$apartment['beds_n']}} Bagni
                                    @endif
                                </p>
                                <p>Asciugamani e prodotti per la pulizia inclusi.</p>
                            </div>
                        </div>
                    </section>

                    <hr>

                    <section class="apartment-description">
                        <p>{{$apartment['description']}}</p>
                    </section>

                    <hr>

                    <section class="additional-services">

                        <h3 class="heading--primary">Servizi Inclusi</h3>
                        <div class="service-list">

                            @foreach ($apartment['services'] as $service)
                            
                                <div class="single-service">
                                    <i class="single-service__icon fas fa-{{$service['service_icon']}}"></i>
                                    <span class="single-service__name">{{$service['service_name']}}</span>
                                </div>                            
                            
                            @endforeach
                            
                        </div>

                    </section>

                </div>




                <div class="right-container">
                    <div id="form-anchor" class="contact-form">

                        {{-- FORM INVIO MESSAGGIO----------- --}}
                        <form action="{{ route('saveMessage') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <h3 class="heading--primary">Contatta l'host per conoscere i dettagli</h3>
                            <p> <i class="fas fa-star"></i> 5.0 &#183 Rome , Italy</p>

                            {{-- MAIL---------- --}}
                            @php
                                use Illuminate\Support\Facades\Auth;
                                $isLoggedIn = Auth::check() ? true : false;
                            @endphp

                            <div class="form-group">
                                <input type="email" name="email_sender" class="form__input" placeholder="Inserisci email" value="{{$isLoggedIn ? Auth::user()->email : null }}" required>
                                @error('email_sender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TESTO MESSAGGIO----------- --}}
                            <div class="form-group">
                                <textarea class="form__input" name="message_text" id="message_text" name="message_text" placeholder="Scrivi un messaggio per il proprietario" required minlength="50"></textarea>
                                @error('message_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- ID APT---------- --}}
                            <div class="form-group">
                                <input type="hidden" name="apartment_id" value="{{ $apartment['id'] }}">
                            </div>

                           <button class="btn btn--primary" type="submit">Invia Messaggio</button>

                        </form>
                        

                    </div>
                </div>
            </div>

            <hr>
            
            {{-- Mappa appartamento --}}

            <section class="apartment-map">
                <div class="map-title">
                    <h3 class="heading--primary">Posizione</h3>

                    <p>{{$apartment['address']}}</p>
                    <p>
                        <span><strong class="color-primary">Lat:</strong>{{$apartment['latitude']}}</span> <span><strong class="color-primary">Lon:</strong>{{$apartment['longitude']}}</span>
                    </p>

                </div>
                
            <single-chalet-map
                :longitude="{{$apartment['longitude']}}" 
                :latitude="{{$apartment['latitude']}}">
    
                <!-- Mappa -->
    
            </single-chalet-map>

            </section>
            
            <hr>
            
            {{-- Piccola Sezione Host             --}}

            <section class="hosted-by">

                <section class="type-host">

                    <div class="host-img">
                        <img src="https://thumbs.dreamstime.com/b/default-avatar-profile-icon-vector-social-media-user-image-182145777.jpg"
                            alt="host-img">
                    </div>

                    <div class="little-description">
                        <h3>Host: {{ $apartment['host']['name']}} {{ $apartment['host']['surname'] }} </h3>
                        <p> Membro da gennaio 2015</p>
                    </div>
                    
                </section>

                <section class="section-price">
                    <p>Tanti Chalet simili a <span class="color-primary">{{$apartment['title']}}</span> sono già al completo sul nostro sito. Non farti sfuggire questa occasione e prenota subito a soli <span class="color-primary">{{$apartment['price_per_night']}}&euro;</span> a notte, senza commissioni e con cancellazione gratuita*!</p>
                </section>

                <section class="redirect-btn">
                    {{--Al click la pagina si ridireziona al form di inserimento messaggio --}}

                    <a href="#form-anchor" class="btn btn--primary host-btn">
                        Contatta l'host ora
                    </a>
                </section>

            </section>


        <hr>

            {{-- Slider di apt sponsorizzati --}}

        <section class="sponsored-apt-section">
            
            <h3 class="heading--primary">Altri chalet in evidenza</h3>

            <p>Non sei del tutto sicuro? Da' un'occhiata anche a questi chalet, selezionati fra le migliori opzioni oggi esistenti in Italia!</p>

                <sponsored-slider></sponsored-slider>

        </section>


    </div>

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